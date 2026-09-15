---
title: Select Filter
description: Filter by one or more values from a list of options.
order: 2
---

# Select Filter

```php
use Laravilt\QueryBuilder\Filters\SelectFilter;

SelectFilter::make('status')
    ->options([
        'active' => 'Active',
        'inactive' => 'Inactive',
    ])
    ->default('active');
```

## Multiple values

```php
SelectFilter::make('category_id')
    ->label('Categories')
    ->options(Category::pluck('name', 'id')->all())
    ->multiple()
    ->searchable();
```

| Mode | SQL |
|------|-----|
| Single | `WHERE col = 'value'` |
| `multiple()` with an array value | `WHERE col IN ('a', 'b')` |

## Methods

| Method | Description |
|--------|-------------|
| `options(array)` | Value => label options |
| `multiple(bool)` | Allow several values |
| `searchable(bool)` | Searchable dropdown (frontend) |
