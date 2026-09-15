---
title: Page Widgets & Actions
description: Add widgets, header actions, subheadings and breadcrumbs to pages.
order: 4
---

# Page Widgets & Actions

## Page with Widgets

Return widget classes or instances from `getWidgets()`. They render above the page content, and stat widgets are grouped into one stats row.

```php
<?php

namespace App\Laravilt\Admin\Pages;

use App\Laravilt\Admin\Widgets\RevenueChartWidget;
use App\Models\Order;
use App\Models\User;
use Laravilt\Panel\Pages\Page;
use Laravilt\Widgets\Stat;
use Laravilt\Widgets\StatsOverviewWidget;

class Overview extends Page
{
    protected static ?string $navigationIcon = 'LayoutDashboard';

    public function getWidgets(): array
    {
        return [
            StatsOverviewWidget::make()
                ->stats([
                    Stat::make('Users', User::count())->icon('Users'),
                    Stat::make('Orders', Order::count())
                        ->description('All time')
                        ->color('success'),
                ])
                ->columns(2),
            RevenueChartWidget::class,
        ];
    }
}
```

## Customizing the Dashboard

The generated `app/Laravilt/{Panel}/Pages/Dashboard.php` extends `Laravilt\Panel\Pages\Dashboard`. By default it shows a stats row with a record count for each resource. Override `getWidgets()` to add your own widgets:

```php
namespace App\Laravilt\Admin\Pages;

use App\Laravilt\Admin\Widgets\LatestOrdersWidget;

class Dashboard extends \Laravilt\Panel\Pages\Dashboard
{
    protected static bool $shouldGenerateResourceStats = true;

    protected static int $statsColumns = 4;

    public function getWidgets(): array
    {
        return [
            LatestOrdersWidget::class,
        ];
    }
}
```

A resource can opt out of the automatic stats with `protected static bool $showOnDashboard = false;`.

## Header Actions

```php
use Laravilt\Actions\Action;

public function getHeaderActions(): array
{
    return [
        Action::make('export')
            ->label('Export Data')
            ->icon('Download')
            ->action(fn () => $this->export()),
    ];
}
```

## Subheading

```php
public function getSubheading(): ?string
{
    return 'Welcome back, '.auth()->user()->name;
}
```

## Breadcrumbs

Breadcrumbs are built automatically from the panel dashboard, cluster or navigation group, and page title. Override `getBreadcrumbs()` to replace them:

```php
public function getBreadcrumbs(): array
{
    return [
        ['label' => 'Settings', 'url' => '/admin/settings'],
        ['label' => 'General', 'url' => null],
    ];
}
```

## Related

- [Widgets](../../widgets/README.md): stats, charts and custom widgets
- [Actions](../../actions/README.md)
