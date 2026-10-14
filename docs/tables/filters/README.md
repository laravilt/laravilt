---
title: Filters
description: Filter table records with select, ternary, trashed, and custom filters.
order: 2
---

# Filters

Filters live in the `Laravilt\Tables\Filters` namespace. Pass them to `$table->filters([...])`.

| Filter | Purpose |
|--------|---------|
| [SelectFilter](select-filter.md) | Pick one or more values, optionally from a relationship |
| [TernaryFilter](ternary-filter.md) | Yes / No / All |
| [TrashedFilter](trashed-filter.md) | Include or show only soft-deleted records |
| `QueryFilter` | A toggle that applies a custom query when switched on |
| `Filter` | Any form field plus your own query |

```php
use Laravilt\Tables\Filters\SelectFilter;
use Laravilt\Tables\Filters\TernaryFilter;

$table->filters([
    SelectFilter::make('status')
        ->options([
            'draft' => 'Draft',
            'published' => 'Published',
        ]),

    TernaryFilter::make('is_featured')
        ->label('Featured'),
]);
```

## Toggle filters

```php
use Laravilt\Tables\Filters\QueryFilter;

QueryFilter::make('verified')
    ->label('Verified only')
    ->query(fn ($query) => $query->whereNotNull('email_verified_at'));
```

## Custom form filters

Use any [form field](../../forms/README.md) as the filter input. The query closure receives the query and the submitted value:

```php
use Laravilt\Forms\Components\DatePicker;
use Laravilt\Tables\Filters\Filter;

Filter::make('created_from')
    ->form([
        DatePicker::make('created_from'),
    ])
    ->query(fn ($query, $value) => $query->whereDate('created_at', '>=', $value));
```

## Shared options

| Method | Description |
|--------|-------------|
| `label()` | Filter label |
| `default()` | Default value |
| `attribute()` | Database column when it differs from the filter name |
| `query()` | Custom query: `fn ($query, $value) => ...` |
| `indicateUsing()` | Active-filter badge text: `fn ($value) => "Status: {$value}"` |
| `form()` / `schema()` | Custom form field(s) |

## Layout

```php
$table->filtersLayout('dropdown'); // 'sidebar' (default), 'dropdown', or 'above_table'
```

| Value | Result |
|-------|--------|
| `sidebar` (default) | Filters open in a slide-over panel |
| `dropdown` | Filters open in a popover |
| `above_table` | Filters render inline in a bar above the records |

You can also pass the enum: `$table->filtersLayout(FiltersLayout::AboveTable)`
(`Laravilt\Tables\Enums\FiltersLayout`). Filament-style names such as
`above_content` and `modal` are accepted as aliases, and unknown values throw an
`InvalidArgumentException`.

## Multi-field filter forms

`->form([...])` accepts several fields. They render together under the filter,
and the query callback receives the full form data array:

```php
Filter::make('start_datetime')
    ->form([
        DatePicker::make('start_date'),
        TimePicker::make('start_time'),
    ])
    ->query(fn ($query, array $data) => $query
        ->when($data['start_date'] ?? null, fn ($q, $d) => $q->whereDate('starts_at', '>=', $d))
        ->when($data['start_time'] ?? null, fn ($q, $t) => $q->whereTime('starts_at', '>=', $t)));
```

A form with a single field named like the filter keeps passing a scalar value.

## Filter state and URLs

Active filters live in the URL (`?status=live`, `?tags[]=a&tags[]=b`,
`?start_datetime[start_date]=2026-02-01`). The table reads them back on load, so
filters keep their value after a refresh or when the URL is entered manually.
This works for select, ternary, trashed and custom form filters.
