---
title: Filters
description: Filter types for the query builder and the options they share.
order: 1
---

# Filters

Filters live in `Laravilt\QueryBuilder\Filters`:

1. [Text Filter](text.md): contains, exact, starts with, ends with
2. [Select Filter](select.md): single or multiple values
3. [Boolean Filter](boolean.md): true/false
4. [Date Filter](date.md): equal, before, after, between

## Shared methods

```php
use Laravilt\QueryBuilder\Filters\TextFilter;

TextFilter::make('customer')
    ->label('Customer')
    ->column('customer_name')
    ->default('')
    ->placeholder('Search customers...')
    ->visible(auth()->user()->isAdmin());
```

| Method | Description |
|--------|-------------|
| `make(string $name)` | Create a filter; the name is also the default column |
| `label(string)` | Display label (defaults to the headline form of the name) |
| `column(string)` | Database column |
| `default(mixed)` | Default value (serialized for the frontend) |
| `placeholder(string)` | Placeholder text |
| `visible(bool)` | Show or hide the filter |
| `query(Closure)` | Replace the default constraint |

## Custom query

`query()` receives the builder and the value, and replaces the filter's default constraint:

```php
TextFilter::make('search')
    ->query(function ($query, $value) {
        $query->where(fn ($q) => $q
            ->where('name', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%{$value}%"));
    });
```

To build your own filter type, extend `Laravilt\QueryBuilder\Filters\Filter` and implement `applyDefault(Builder $query, mixed $value): void`.
