---
title: Widgets
description: Stats cards and charts for dashboards and pages.
order: 9
---

# Widgets

The `laravilt/widgets` package provides dashboard building blocks: a grid of stat cards and line, bar and pie charts. You describe a widget in PHP, and the panel renders it with its Vue 3 or React 19 components (charts are drawn with Chart.js). Any widget can refresh itself with polling.

> React support requires Laravilt v1.1 or later.

```php
use Laravilt\Widgets\Stat;
use Laravilt\Widgets\StatsOverviewWidget;

StatsOverviewWidget::make()
    ->heading('Overview')
    ->columns(3)
    ->stats([
        Stat::make('Users', fn () => User::count())
            ->icon('Users')
            ->color('primary'),
        Stat::make('Revenue', '$12,345')
            ->description('+12% from last month')
            ->color('success'),
    ])
    ->polling(30);
```

The default dashboard also adds a stat card for every resource automatically.

## In this section

1. [Widget Types](types/README.md): [Stats Overview](types/stats-overview.md), [Line Chart](types/line-chart.md), [Bar Chart](types/bar-chart.md), [Pie Chart](types/pie-chart.md)
2. [Custom Widgets](custom-widgets.md): generate widget classes and add them to dashboards and pages

## Shared methods

Every widget extends `Laravilt\Widgets\Widget`:

| Method | Description |
|--------|-------------|
| `make()` | Create an instance (static) |
| `heading(string $heading)` | Title |
| `description(string $description)` | Text under the title |
| `icon(string $icon)` | Icon name |
| `color(string $color)` | `primary`, `secondary`, `success`, `danger`, `warning` or `info` |
| `polling(?int $interval = 10)` | Refresh every `$interval` seconds |
| `extraAttributes(string $attributes)` | Extra HTML attributes for the wrapper |

## Installation

Widgets ship with Laravilt. To republish the package files:

```bash
php artisan widgets:install [--force] [--without-assets]
```

## Related

- [Panel](../panel/README.md)
- [Live demo dashboard](https://demo.laravilt.com) (log in with `admin@laravilt.com` / `password`)
