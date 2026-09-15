---
title: Bar Chart
description: Vertical, horizontal and stacked bar charts.
order: 3
---

# Bar Chart Widget

## Basic usage

```php
use Laravilt\Widgets\BarChartWidget;

BarChartWidget::make(
    labels: ['Electronics', 'Furniture', 'Clothing', 'Sports'],
    datasets: [
        [
            'label' => 'Sales',
            'data' => [150, 89, 120, 65],
            'backgroundColor' => 'rgb(59, 130, 246)',
        ],
    ],
)
    ->heading('Sales by category')
    ->description('Units sold this quarter');
```

## Horizontal and stacked

```php
BarChartWidget::make(
    labels: ['Q1', 'Q2', 'Q3', 'Q4'],
    datasets: [
        ['label' => 'Product A', 'data' => [100, 120, 90, 150], 'backgroundColor' => 'rgb(59, 130, 246)'],
        ['label' => 'Product B', 'data' => [80, 100, 110, 95], 'backgroundColor' => 'rgb(34, 197, 94)'],
    ],
)
    ->stacked()
    ->horizontal();
```

## Styling

```php
BarChartWidget::make($labels, $datasets)
    ->showGrid()
    ->barThickness(20)
    ->height(300)
    ->polling(60);
```

## Methods

| Method | Description |
|--------|-------------|
| `make(array $labels = [], array $datasets = [])` | Create the chart (static) |
| `horizontal(bool $condition = true)` | Horizontal bars |
| `stacked(bool $condition = true)` | Stack datasets |
| `showGrid(bool $condition = true)` | Show grid lines |
| `barThickness(int $thickness)` | Bar thickness in pixels |
| `data(array $data)` | Set `labels` and `datasets` directly |
| `options(array $options)` | Chart.js options (replaces options set by the helpers) |
| `height(int $height)` | Height in pixels |
| plus `heading()`, `description()`, `polling()` ... | See [shared methods](../README.md#shared-methods) |

## Related

- [Line Chart](line-chart.md)
- [Pie Chart](pie-chart.md)
