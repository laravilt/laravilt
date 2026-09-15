---
title: Pie Chart
description: Pie and doughnut charts for proportions.
order: 4
---

# Pie Chart Widget

A pie chart takes one series of values. You pass a plain `data` array instead of Chart.js datasets.

## Basic usage

```php
use Laravilt\Widgets\PieChartWidget;

PieChartWidget::make(
    labels: ['Electronics', 'Furniture', 'Clothing'],
    data: [45, 30, 25],
)
    ->heading('Sales distribution')
    ->description('By category');
```

## Doughnut, legend and percentages

```php
PieChartWidget::make($labels, $data)
    ->doughnut()
    ->showLegend()
    ->showPercentage()
    ->height(300);
```

## Dynamic data

```php
$statuses = ['completed', 'processing', 'pending', 'cancelled'];

PieChartWidget::make(
    labels: array_map('ucfirst', $statuses),
    data: array_map(fn ($status) => Order::where('status', $status)->count(), $statuses),
)
    ->heading('Order status')
    ->doughnut()
    ->polling(60);
```

## Methods

| Method | Description |
|--------|-------------|
| `make(array $labels = [], array $data = [])` | Create the chart (static) |
| `doughnut(bool $condition = true)` | Render as a doughnut |
| `showLegend(bool $condition = true)` | Show the legend |
| `showPercentage(bool $condition = true)` | Show percentages |
| `data(array $data)` | Set `labels` and `datasets` directly |
| `options(array $options)` | Chart.js options (replaces options set by the helpers) |
| `height(int $height)` | Height in pixels |
| plus `heading()`, `description()`, `polling()` ... | See [shared methods](../README.md#shared-methods) |

## Related

- [Line Chart](line-chart.md)
- [Bar Chart](bar-chart.md)
