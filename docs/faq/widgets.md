---
title: Widgets FAQ
description: Questions about stats and chart widgets on dashboards.
order: 5
---

# Widgets FAQ

Dashboard charts and stats are built in PHP with `laravilt/widgets`. There are no separate frontend chart components to import.

## How do I create a stats widget?

```php
use Laravilt\Widgets\Stat;
use Laravilt\Widgets\StatsOverviewWidget;

StatsOverviewWidget::make()
    ->columns(3)
    ->stats([
        Stat::make('Users', User::count())->icon('Users')->color('primary'),
        Stat::make('Revenue', '$12,345')->description('+12%')->color('success'),
    ]);
```

## How do I add a trend icon or mini chart to a stat?

```php
Stat::make('Sales', '$8,200')
    ->description('+15%')
    ->descriptionIcon('TrendingUp', 'success')
    ->chart([65, 59, 80, 81, 56, 55, 70], 'line', 'primary');
```

See [Stats Overview](../widgets/types/stats-overview.md).

## How do I create a line or bar chart?

```php
use Laravilt\Widgets\BarChartWidget;
use Laravilt\Widgets\LineChartWidget;

LineChartWidget::make(
    labels: ['Jan', 'Feb', 'Mar', 'Apr'],
    datasets: [['label' => 'Revenue', 'data' => [4500, 5200, 4800, 6100]]],
)
    ->heading('Revenue Trend')
    ->curved()
    ->fill();

BarChartWidget::make(
    labels: ['Q1', 'Q2', 'Q3', 'Q4'],
    datasets: [['label' => 'Sales', 'data' => [150, 200, 180, 250]]],
)->stacked();
```

`PieChartWidget::make(labels: [...], data: [...])` is also available. See [Line Chart](../widgets/types/line-chart.md), [Bar Chart](../widgets/types/bar-chart.md) and [Pie Chart](../widgets/types/pie-chart.md).

## How do I refresh a widget automatically?

```php
StatsOverviewWidget::make()
    ->polling(30) // seconds
    ->stats([...]);
```

## Related

- [Widgets Documentation](../widgets/README.md)
- [Stats Overview](../widgets/types/stats-overview.md)
