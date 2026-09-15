---
title: Checkbox
description: Single checkbox for boolean values.
order: 3
---

# Checkbox

A single checkbox for boolean values.

## Basic usage

```php
use Laravilt\Forms\Components\Checkbox;

Checkbox::make('is_active')
    ->label('Active')
    ->default(true);
```

## Must be accepted

```php
Checkbox::make('terms_accepted')
    ->label('I accept the terms and conditions')
    ->rules(['accepted']);
```

## Custom values and description

```php
Checkbox::make('status')
    ->checkedValue('enabled')
    ->uncheckedValue('disabled')
    ->description('Enable the feature for all users');
```

## API reference

| Method | Description |
|--------|-------------|
| `checkedValue(mixed)` | Value stored when checked |
| `uncheckedValue(mixed)` | Value stored when unchecked |
| `description(string\|Closure)` | Text below the label |
| `inline(bool)` | Inline layout |

For several checkboxes, use [CheckboxList](checkbox-list.md).
