---
title: AI Columns
description: Describe the columns an AI agent can search, filter, sort and write.
order: 9
---

# AI Columns

`AIColumn` describes a model attribute to the AI agent so it can query, filter and manage records.

## Basic Column

```php
use Laravilt\AI\AIColumn;

AIColumn::make('name')
    ->label('Product Name')
    ->description('The public product name');
```

## Column Types

```php
AIColumn::make('name')->type('string');
AIColumn::make('price')->type('decimal');
AIColumn::make('stock')->type('integer');
AIColumn::make('is_active')->type('boolean');
AIColumn::make('created_at')->type('datetime');
```

## Capabilities

```php
AIColumn::make('name')->searchable();
AIColumn::make('status')->filterable()->options([
    'draft' => 'Draft',
    'published' => 'Published',
]);
AIColumn::make('price')->sortable();
```

## Relationship Columns

```php
AIColumn::make('category')
    ->relationship('category', 'name')   // relationship, title column (default: name)
    ->filterable();
```

## Complete Example

```php
use Laravilt\AI\AIAgent;
use Laravilt\AI\AIColumn;

public static function ai(AIAgent $agent): AIAgent
{
    return $agent->columns([
        AIColumn::make('id')->type('integer'),
        AIColumn::make('name')->label('Product Name')->searchable()->sortable(),
        AIColumn::make('price')->type('decimal')->filterable()->sortable(),
        AIColumn::make('is_active')->type('boolean')->filterable(),
        AIColumn::make('category')->relationship('category', 'name')->filterable(),
    ]);
}
```

## AIColumn Methods

| Method | Parameters | Description |
|--------|-----------|-------------|
| `make()` | `string $name` | Create column |
| `label()` | `string` | Display label |
| `description()` | `string` | Hint for the AI |
| `type()` | `string` | Data type |
| `options()` | `array` | Allowed values |
| `searchable()` | `bool = true` | Enable search |
| `filterable()` | `bool = true` | Enable filtering |
| `sortable()` | `bool = true` | Enable sorting |
| `relationship()` | `string, string = 'name'` | Relationship and title column |
