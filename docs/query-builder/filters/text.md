---
title: Text Filter
description: Filter by text with contains, exact, prefix, or suffix matching.
order: 1
---

# Text Filter

```php
use Laravilt\QueryBuilder\Filters\TextFilter;

TextFilter::make('name')
    ->label('Product name')
    ->contains()
    ->placeholder('Search products...');
```

## Matching modes

| Method | SQL |
|--------|-----|
| `contains()` (default) | `WHERE col LIKE '%value%'` |
| `exact()` | `WHERE col = 'value'` |
| `startsWith()` | `WHERE col LIKE 'value%'` |
| `endsWith()` | `WHERE col LIKE '%value'` |
| `operator('>=')` | `WHERE col >= 'value'` (any other operator) |

`caseSensitive()` is passed to the frontend. It doesn't change the SQL, so case sensitivity depends on your database collation.
