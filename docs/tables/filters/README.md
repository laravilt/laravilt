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
