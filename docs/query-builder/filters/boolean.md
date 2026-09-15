---
title: Boolean Filter
description: Filter a boolean column by true or false.
order: 3
---

# Boolean Filter

```php
use Laravilt\QueryBuilder\Filters\BooleanFilter;

BooleanFilter::make('is_featured')
    ->label('Featured')
    ->trueLabel('Featured')
    ->falseLabel('Not featured');
```

The value is converted with `filter_var($value, FILTER_VALIDATE_BOOLEAN)`, so `true`, `'true'`, `1`, `'1'`, and `'on'` mean true, and anything else means false. The filter then applies `WHERE col = true|false`.

## Methods

| Method | Description |
|--------|-------------|
| `trueLabel(string)` | Label for true (default "Yes") |
| `falseLabel(string)` | Label for false (default "No") |
