---
title: Selection
description: Fields for choosing from predefined options.
order: 2
---

# Selection

Fields for choosing from a set of options.

| Component | Description |
|-----------|-------------|
| [Select](select.md) | Dropdown with search, multiple selection and relationships |
| [Radio](radio.md) | Radio button group |
| [Checkbox](checkbox.md) | Single checkbox |
| [CheckboxList](checkbox-list.md) | Multiple checkboxes |
| [Toggle](toggle.md) | On/off switch |
| [ToggleButtons](toggle-buttons.md) | Button group |

## Options

Every selection field takes `options()` as an array or a closure:

```php
use Laravilt\Forms\Components\Select;

Select::make('status')
    ->options([
        'draft' => 'Draft',
        'published' => 'Published',
    ])
    ->required();

Select::make('category_id')
    ->options(fn () => Category::pluck('name', 'id')->all())
    ->searchable();
```

## Relationships

`Select` and `CheckboxList` can load their options from an Eloquent relationship:

```php
Select::make('user_id')
    ->relationship('user', 'name')
    ->searchable()
    ->preload();
```
