---
title: Custom Widgets
description: Generate widget classes and show them on dashboards and pages.
order: 2
---

# Custom Widgets

## Generating a widget

```bash
php artisan laravilt:widget {name?} [--panel=] [--type=basic|stats|chart] [--chart=line|bar|pie|doughnut|area]
```

```bash
php artisan laravilt:widget RecentOrders --panel=Admin
php artisan laravilt:widget DashboardStats --panel=Admin --type=stats
php artisan laravilt:widget SalesChart --panel=Admin --type=chart --chart=line
```

With `--panel`, the class is created in `app/Laravilt/{Panel}/Widgets` (namespace `App\Laravilt\{Panel}\Widgets`). Without it, the class goes to `app/Widgets`. Missing options are asked interactively, including whether to enable polling.

## Stats widget

```php
<?php

namespace App\Laravilt\Admin\Widgets;

use App\Models\Order;
use App\Models\User;
use Laravilt\Widgets\Stat;
use Laravilt\Widgets\StatsOverviewWidget;

class DashboardStats extends StatsOverviewWidget
{
    protected ?string $heading = 'Overview';

    public function __construct()
    {
        $this->stats($this->getStats());
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Revenue', fn () => '$'.number_format(Order::sum('total'), 2))
                ->icon('DollarSign')
                ->color('success'),

            Stat::make('Users', fn () => User::count())
                ->icon('Users')
                ->color('primary'),
        ];
    }
}
```

## Chart widget

```php
<?php

namespace App\Laravilt\Admin\Widgets;

use App\Models\Order;
use Laravilt\Widgets\LineChartWidget;

class SalesChart extends LineChartWidget
{
    protected ?string $heading = 'Sales (last 30 days)';

    public function __construct()
    {
        $this->data($this->getData())->curved()->fill();
    }

    protected function getData(): array
    {
        $sales = Order::selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'labels' => $sales->pluck('date')->all(),
            'datasets' => [
                ['label' => 'Sales', 'data' => $sales->pluck('total')->all(), 'borderColor' => 'rgb(34, 197, 94)'],
            ],
        ];
    }
}
```

## Basic widget

A basic widget extends `Laravilt\Widgets\Widget` and implements `toInertiaProps()`. The `component` key selects the frontend component that renders it:

```php
use Laravilt\Widgets\Widget;

class RecentOrders extends Widget
{
    protected ?string $heading = 'Recent orders';

    public function toInertiaProps(): array
    {
        return [
            'component' => 'BasicWidget',
            'heading' => $this->heading,
            'description' => $this->description,
            'data' => Order::latest()->limit(5)->get(['id', 'total'])->toArray(),
            'polling' => [
                'enabled' => $this->pollingEnabled,
                'interval' => $this->pollingInterval,
            ],
        ];
    }
}
```

## Showing widgets

Any panel page with a `getWidgets()` method renders those widgets above its content. Return widget instances or class names. Class names are instantiated with no constructor arguments.

To customize the dashboard, extend the panel's `Dashboard` page:

```php
<?php

namespace App\Laravilt\Admin\Pages;

use App\Laravilt\Admin\Widgets\DashboardStats;
use App\Laravilt\Admin\Widgets\SalesChart;
use Laravilt\Panel\Pages\Dashboard as BaseDashboard;
use Laravilt\Widgets\PieChartWidget;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            DashboardStats::class,
            (new SalesChart)->height(350)->polling(60),
            PieChartWidget::make(['Paid', 'Unpaid'], [70, 30])->heading('Invoices'),
        ];
    }
}
```

The dashboard also has `getHeaderWidgets()`, which by default returns the automatic resource stats followed by `getWidgets()`, and `getFooterWidgets()`, which renders widgets below the content. See [Pages](../panel/pages/README.md) for registering pages in a panel.

## Related

- [Stats Overview](types/stats-overview.md)
- [Line Chart](types/line-chart.md)
