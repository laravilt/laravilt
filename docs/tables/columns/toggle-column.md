---
title: ToggleColumn
description: Inline switch that updates a boolean attribute directly from the table.
order: 5
---

# ToggleColumn

```php
use Laravilt\Tables\Columns\ToggleColumn;

ToggleColumn::make('is_active')
    ->label('Active');
```

When the user flips the switch, the panel saves the new value to the record. You don't need to save it yourself. From Laravilt v1.1, the switch saves through the shared column update endpoint. That endpoint checks `canUpdate()`, validates the value as `required|boolean` plus your `rules()`, and writes only this column's attribute. See [Editable columns](README.md#editable-columns).

## Hooks

`beforeStateUpdated()` and `afterStateUpdated()` receive the record, the column name, and the new value:

```php
use Laravilt\Notifications\Notification;

ToggleColumn::make('is_featured')
    ->afterStateUpdated(function ($record, string $column, $value) {
        Notification::success()
            ->title($value ? 'Featured' : 'Unfeatured')
            ->send();
    });
```

## Validation and disabling

```php
ToggleColumn::make('is_published')
    ->rules(['boolean'])
    ->disabled(fn () => ! auth()->user()->isAdmin());
```

## API reference

| Method | Description |
|--------|-------------|
| `beforeStateUpdated()` | Runs before the value is saved |
| `afterStateUpdated()` | Runs after the value is saved |
| `rules()` | Validation rules |
| `disabled()` | Disable the switch |
