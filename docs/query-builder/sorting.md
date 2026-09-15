---
title: Sorting
description: Define sort options and apply the active sort.
order: 2
---

# Sorting

```php
use Laravilt\QueryBuilder\Sort;

$builder->sorts([
    Sort::make('name'),
    Sort::make('created_at')->defaultDirection('desc'),
    Sort::make('price', 'price_cents')->label('Price'), // name, database column
]);
```

## Applying the sort

`sortBy()` sets the active column and direction, and `apply()` adds `orderBy()`:

```php
$builder->sortBy(
    $request->input('sort'),
    $request->input('direction', 'asc'),
);
```

> `sortBy()` orders by the value you pass. It doesn't check it against the registered `Sort` names, so validate user input yourself:
>
> ```php
> $allowed = ['name', 'created_at', 'price_cents'];
> $sort = in_array($request->input('sort'), $allowed, true) ? $request->input('sort') : 'created_at';
> ```

## Labels

When `label()` isn't set, the label is the headline form of the name: `created_at` becomes "Created At".

## Methods

| Method | Description |
|--------|-------------|
| `make(string $name, ?string $column = null)` | Create a sort option |
| `label(string)` | Display label |
| `column(string)` | Database column |
| `defaultDirection(string)` | `asc` or `desc` (serialized for the frontend) |
| `visible(bool)` | Show or hide the option |
| `getName()`, `getColumn()`, `getLabel()` | Getters |
