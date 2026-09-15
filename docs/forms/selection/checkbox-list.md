---
title: CheckboxList
description: Multiple checkboxes with columns, search, bulk toggle and grouping.
order: 4
---

# CheckboxList

A list of checkboxes for selecting several options.

## Basic usage

```php
use Laravilt\Forms\Components\CheckboxList;

CheckboxList::make('technologies')
    ->options([
        'php' => 'PHP',
        'laravel' => 'Laravel',
        'vue' => 'Vue.js',
    ]);
```

## Columns, search and bulk toggle

```php
CheckboxList::make('permissions')
    ->options([
        'create' => 'Create',
        'read' => 'Read',
        'update' => 'Update',
        'delete' => 'Delete',
    ])
    ->columns(2)
    ->searchable()
    ->bulkToggleable();
```

## Relationship

```php
CheckboxList::make('roles')
    ->relationship('roles', 'name');
```

## Grouping

```php
CheckboxList::make('permissions')
    ->relationship('permissions', 'name')
    ->groupBy('group', ['users' => 'User Management'])
    ->groupSelectAll()
    ->collapsible();
```

## API reference

| Method | Description |
|--------|-------------|
| `options(array\|Closure)` | Set options |
| `relationship(name, titleAttribute, ?modifyQuery)` | Load from a relationship |
| `columns(?int)` | Number of columns |
| `gridDirection(string)` | Fill order of the grid |
| `searchable(bool)` | Filter options |
| `bulkToggleable(bool)` | Select-all / deselect-all |
| `inline(bool)` | Inline layout |
| `groupBy(attribute, labels)` / `groupLabels(array)` | Group options |
| `groupSelectAll(bool)` / `collapsible(bool)` / `defaultGroup(?string)` | Group behaviour |
