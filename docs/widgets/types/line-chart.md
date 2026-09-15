---
title: Line Chart
description: Line and area charts for trends over time.
order: 2
---

# Line Chart Widget

## Basic usage

```php
use Laravilt\Widgets\LineChartWidget;

LineChartWidget::make(
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
    datasets: [
        [
            'label' => 'Revenue',
            'data' => [4500, 5200, 4800, 6100, 5900, 6800],
            'borderColor' => 'rgb(34, 197, 94)',
        ],
    ],
)
    ->heading('Revenue trend')
    ->description('Monthly revenue');
```

Datasets use the Chart.js dataset format.

## Styling

```php
LineChartWidget::make($labels, $datasets)
    ->curved()       // smooth lines
    ->fill()         // area chart
    ->showPoints()   // draw data points
    ->showGrid()     // grid lines
    ->height(350);
```

## Multiple datasets

```php
LineChartWidget::make(
    labels: ['Jan', 'Feb', 'Mar', 'Apr'],
    datasets: [
        ['label' => 'Revenue', 'data' => [4500, 5200, 4800, 6100], 'borderColor' => 'rgb(34, 197, 94)'],
        ['label' => 'Expenses', 'data' => [3000, 3500, 3200, 4000], 'borderColor' => 'rgb(239, 68, 68)'],
    ],
)->curved();
```

## Chart.js options and polling

```php
LineChartWidget::make($labels, $datasets)
    ->options(['scales' => ['y' => ['beginAtZero' => true]]])
    ->polling(60);
```

`options()` replaces the whole options array, including anything set by `curved()`, `fill()`, `showPoints()` or `showGrid()`. Call it first, then the helpers.

## Methods

| Method | Description |
|--------|-------------|
| `make(array $labels = [], array $datasets = [])` | Create the chart (static) |
| `curved(bool $condition = true)` | Smooth lines |
| `fill(bool $condition = true)` | Fill the area under the line |
| `showPoints(bool $condition = true)` | Show data points |
| `showGrid(bool $condition = true)` | Show grid lines |
| `data(array $data)` | Set `labels` and `datasets` directly |
| `options(array $options)` | Chart.js options |
| `height(int $height)` | Height in pixels |
| plus `heading()`, `description()`, `polling()` ... | See [shared methods](../README.md#shared-methods) |

## Related

- [Bar Chart](bar-chart.md)
- [Pie Chart](pie-chart.md)
