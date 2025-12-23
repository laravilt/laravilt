---
title: Resource API
description: Expose resources as REST API endpoints
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
concept: resources
---

# Resource API

Expose your resources as REST API endpoints with automatic documentation.

## Basic API Configuration

```php
<?php

namespace App\Laravilt\Admin\Resources\Category;

use App\Models\Category;
use Laravilt\Panel\Resources\Resource;
use Laravilt\Tables\ApiColumn;
use Laravilt\Tables\ApiResource;

class CategoryResource extends Resource
{
    protected static string $model = Category::class;

    public static function api(ApiResource $api): ApiResource
    {
        return $api
            ->description('Categories API - Manage product categories')
            ->authenticated()
            ->columns([
                ApiColumn::make('id')->type('integer'),
                ApiColumn::make('name')->type('string')->searchable(),
                ApiColumn::make('slug')->type('string'),
                ApiColumn::make('is_active')->type('boolean')->filterable(),
                ApiColumn::make('created_at')->type('datetime'),
            ])
            ->allowedFilters(['is_active'])
            ->allowedSorts(['name', 'created_at'])
            ->allowedIncludes(['products']);
    }
}
```

## API Columns

```php
use Laravilt\Tables\ApiColumn;

ApiColumn::make('id')->type('integer');
ApiColumn::make('name')->type('string')->searchable();
ApiColumn::make('price')->type('decimal');
ApiColumn::make('is_active')->type('boolean')->filterable();
ApiColumn::make('created_at')->type('datetime');
ApiColumn::make('category.name')->type('string')->label('Category Name');
```

## Column Types

| Type | Description |
|------|-------------|
| `integer` | Integer values |
| `string` | String values |
| `decimal` | Decimal/float values |
| `boolean` | Boolean values |
| `datetime` | DateTime values |

## API Methods

| Method | Description |
|--------|-------------|
| `description()` | API endpoint description |
| `authenticated()` | Require authentication |
| `columns()` | Define available columns |
| `allowedFilters()` | Filterable fields |
| `allowedSorts()` | Sortable fields |
| `allowedIncludes()` | Includable relationships |
| `actions()` | Custom API actions |

## Related

- [API Actions](api-actions) - Custom API actions
