---
title: Stats Overview
description: A responsive grid of stat cards with descriptions, icons and sparklines.
order: 1
---

# Stats Overview Widget

`StatsOverviewWidget` shows a grid of `Stat` cards.

## Basic usage

```php
use Laravilt\Widgets\Stat;
use Laravilt\Widgets\StatsOverviewWidget;

StatsOverviewWidget::make()
    ->heading('Business metrics')
    ->description('Updated every 30 seconds')
    ->columns(4)
    ->polling(30)
    ->stats([
        Stat::make('Total users', User::count()),
        Stat::make('Total orders', Order::count()),
        Stat::make('Revenue', fn () => '$'.number_format(Order::sum('total'), 2)),
    ]);
```

`columns()` defaults to `3`.

## Stat

`Stat::make(string $label, string|int|float|Closure $value)` creates one card. A closure value is evaluated when the widget is rendered, so it re-runs on every poll.

```php
Stat::make('Revenue', '$45,231')
    ->description('+20% from last month')
    ->descriptionIcon('TrendingUp', 'success')
    ->icon('DollarSign')
    ->color('success')
    ->chart([65, 59, 80, 81, 56, 55, 70], 'line', 'success')
    ->url('/admin/orders');
```

### Sparklines

`chart(array $data, ?string $type = 'bar', ?string $color = null)` draws a small chart inside the card. `$type` is `bar` (the default) or `line`:

```php
Stat::make('Sales', '$8,200')->chart([100, 150, 120, 180, 160, 200], 'line', 'success');
Stat::make('Visitors', 1234)->chart([50, 80, 60, 90, 70, 100]);
```

## Methods

**StatsOverviewWidget**

| Method | Description |
|--------|-------------|
| `stats(array $stats)` | The `Stat` cards |
| `columns(int $columns)` | Grid columns (default `3`) |
| plus `heading()`, `description()`, `polling()` ... | See [shared methods](../README.md#shared-methods) |

**Stat**

| Method | Description |
|--------|-------------|
| `make(string $label, string\|int\|float\|Closure $value)` | Create a stat (static) |
| `description(string $description)` | Sub-text |
| `descriptionIcon(string $icon, ?string $color = null)` | Icon next to the description |
| `icon(string $icon)` | Card icon (Lucide name, for example `Users`) |
| `color(string $color)` | Card color |
| `chart(array $data, ?string $type = 'bar', ?string $color = null)` | Sparkline |
| `url(string $url)` | Make the card a link |

## Dashboard resource stats

The panel's default `Dashboard` page adds a stats overview with one card per resource. Turn it off or change its columns in your own dashboard class:

```php
use Laravilt\Panel\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static bool $shouldGenerateResourceStats = false;

    protected static int $statsColumns = 3;
}
```

## Related

- [Line Chart](line-chart.md)
- [Custom Widgets](../custom-widgets.md)
