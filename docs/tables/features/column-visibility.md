---
title: Column Visibility
description: Let users show and hide columns from the column menu.
order: 3
---

# Column Visibility

Columns are toggleable by default, so users can hide them from the column menu.

```php
use Laravilt\Tables\Columns\TextColumn;

// Hidden until the user turns it on
TextColumn::make('updated_at')
    ->toggleable(isToggledHiddenByDefault: true);

// Always visible, not listed in the menu
TextColumn::make('name')
    ->toggleable(false);
```

To remove a column entirely (for example, based on permissions), use `visible()` or `hidden()`:

```php
TextColumn::make('cost_price')
    ->visible(fn () => auth()->user()->isAdmin());
```

## API reference

| Method | Description |
|--------|-------------|
| `toggleable($condition = true, $isToggledHiddenByDefault = false)` | Allow hiding; optionally start hidden |
| `visible()`, `hidden()` | Remove the column entirely |
