---
title: AI Columns
description: Define columns for AI-powered resource operations
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
concept: resources
---

# AI Columns

Define columns that AI can understand and use for querying, filtering, and CRUD operations.

## Basic Column

```php
use Laravilt\AI\AIColumn;

AIColumn::make('name')
    ->label('Product Name');
```

## Column Types

```php
use Laravilt\AI\AIColumn;

AIColumn::make('name')->type('string');
AIColumn::make('price')->type('decimal');
AIColumn::make('stock')->type('integer');
AIColumn::make('is_active')->type('boolean');
AIColumn::make('created_at')->type('datetime');
```

## Searchable Columns

```php
use Laravilt\AI\AIColumn;

AIColumn::make('name')
    ->label('Product Name')
    ->searchable();
```

## Filterable Columns

```php
use Laravilt\AI\AIColumn;

AIColumn::make('status')
    ->label('Status')
    ->filterable();
```

## Sortable Columns

```php
use Laravilt\AI\AIColumn;

AIColumn::make('price')
    ->label('Price')
    ->sortable();
```

## Relationship Columns

```php
use Laravilt\AI\AIColumn;

AIColumn::make('category')
    ->relationship('category', 'name')
    ->filterable();
```

## Complete Example

```php
<?php

namespace App\Laravilt\Admin\Resources\Product;

use Laravilt\Panel\Resources\Resource;
use Laravilt\AI\AIAgent;
use Laravilt\AI\AIColumn;

class ProductResource extends Resource
{
    public static function ai(AIAgent $agent): AIAgent
    {
        return $agent->columns([
            AIColumn::make('id')
                ->type('integer'),
            AIColumn::make('name')
                ->label('Product Name')
                ->searchable()
                ->sortable(),
            AIColumn::make('price')
                ->type('decimal')
                ->filterable()
                ->sortable(),
            AIColumn::make('is_active')
                ->type('boolean')
                ->filterable(),
            AIColumn::make('category.name')
                ->label('Category')
                ->relationship('category', 'name')
                ->filterable(),
        ]);
    }
}
```

## AIColumn Methods

| Method | Parameters | Description |
|--------|-----------|-------------|
| `make()` | `string $name` | Create column |
| `label()` | `string` | Display label |
| `type()` | `string` | Data type |
| `searchable()` | `bool` | Enable search |
| `filterable()` | `bool` | Enable filter |
| `sortable()` | `bool` | Enable sort |
| `relationship()` | `string, string` | Define relationship |
