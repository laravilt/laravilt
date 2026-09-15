---
title: Date Filter
description: Filter by a date that is equal to, before, after, or between values.
order: 4
---

# Date Filter

```php
use Laravilt\QueryBuilder\Filters\DateFilter;

DateFilter::make('created_at')->label('Created');
```

## Operators

| Method | SQL |
|--------|-----|
| (default) | `WHERE col = 'date'` |
| `before()` | `WHERE col < 'date'` |
| `after()` | `WHERE col > 'date'` |
| `between()` | `WHERE col BETWEEN 'from' AND 'to'` (the value must be a two-item array) |
| `operator('<=')` | Any comparison operator |

```php
DateFilter::make('created_at')
    ->between()
    ->minDate('2024-01-01')
    ->maxDate('2024-12-31')
    ->withTime();
```

`minDate()`, `maxDate()`, and `withTime()` configure the date picker on the frontend. They don't add constraints to the query.
