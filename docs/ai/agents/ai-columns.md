---
title: AI Columns
description: Describe resource columns so the model understands your data.
order: 2
---

# AI Columns

`Laravilt\AI\AIColumn` describes a column to the agent: its label, type, and whether it can be searched, filtered or sorted.

```php
use Laravilt\AI\AIColumn;

AIColumn::make('name')
    ->label('Product Name')
    ->description('Public product title')
    ->searchable()
    ->sortable();
```

New columns are searchable by default. Filterable and sortable are off until you enable them.

## Types

`type()` accepts any string. Use the types your model understands:

```php
AIColumn::make('price')->type('decimal');
AIColumn::make('quantity')->type('integer');
AIColumn::make('is_active')->type('boolean');
AIColumn::make('published_at')->type('datetime');
```

## Options and relationships

```php
AIColumn::make('status')
    ->filterable()
    ->options(['active' => 'Active', 'pending' => 'Pending']);

AIColumn::make('category_id')
    ->relationship('category', 'name') // title column defaults to 'name'
    ->filterable();
```

## Methods

| Method | Description |
|--------|-------------|
| `make(string $name)` | Create a column |
| `label(string)` | Display label (defaults to the title-cased name with underscores as spaces) |
| `description(string)` | Extra context |
| `type(string)` | Data type |
| `searchable(bool)` | Searchable (default `true`) |
| `filterable(bool)` | Filterable |
| `sortable(bool)` | Sortable |
| `options(array)` | Allowed values |
| `relationship(string, string $titleColumn = 'name')` | Related model |
