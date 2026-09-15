---
title: Widget Types
description: The built-in stats and chart widgets.
order: 1
---

# Widget Types

Laravilt ships one stats widget and three chart widgets. All chart widgets extend `Laravilt\Widgets\ChartWidget`, which adds `data(array $data)`, `options(array $options)` for raw Chart.js options, and `height(int $height)`.

| Widget | Class | Use it for |
|--------|-------|------------|
| [Stats Overview](stats-overview.md) | `StatsOverviewWidget` + `Stat` | KPI cards with optional sparklines |
| [Line Chart](line-chart.md) | `LineChartWidget` | Trends over time, including area charts |
| [Bar Chart](bar-chart.md) | `BarChartWidget` | Comparing categories, stacked or horizontal |
| [Pie Chart](pie-chart.md) | `PieChartWidget` | Proportions, as pie or doughnut |
