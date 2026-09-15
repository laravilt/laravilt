---
title: TernaryFilter
description: Three-state Yes / No / All filter for boolean or nullable columns.
order: 2
---

# TernaryFilter

```php
use Laravilt\Tables\Filters\TernaryFilter;

TernaryFilter::make('is_active')
    ->label('Active');
```

"Yes" applies `where(is_active, true)`, "No" applies `where(is_active, false)`, and the blank state applies no constraint.

## Labels

```php
TernaryFilter::make('is_featured')
    ->trueLabel('Featured only')
    ->falseLabel('Not featured')
    ->placeholderLabel('All items');
```

## Nullable columns

With `nullable()`, "Yes" means `whereNotNull` and "No" means `whereNull`:

```php
TernaryFilter::make('email_verified_at')
    ->label('Verified')
    ->nullable();
```

## Custom queries

```php
TernaryFilter::make('has_orders')
    ->queries(
        true: fn ($query) => $query->has('orders'),
        false: fn ($query) => $query->doesntHave('orders'),
        blank: fn ($query) => $query,
    );
```

## API reference

| Method | Description |
|--------|-------------|
| `trueLabel()`, `falseLabel()` | Option labels (default "Yes" / "No") |
| `placeholderLabel()` | Label for the blank (all) state |
| `nullable()` | Use `whereNotNull` / `whereNull` |
| `queries()` | Custom `true`, `false`, and `blank` queries |
| `attribute()` | Column name if different from the filter name |
