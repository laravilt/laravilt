---
title: Resource API
description: Expose a resource as REST API endpoints with generated documentation.
order: 6
---

# Resource API

Define an `api()` method on a resource to expose it as REST endpoints.

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

## Endpoints

For a resource with slug `categories` in the `admin` panel:

```
GET    /admin/api/categories        # List
POST   /admin/api/categories        # Create
GET    /admin/api/categories/{id}   # Show
PUT    /admin/api/categories/{id}   # Update
DELETE /admin/api/categories/{id}   # Delete
```

Turn individual operations on or off:

```php
return $api
    ->list()
    ->show()
    ->create(false)
    ->update(false)
    ->delete(false);
```

## API Columns

```php
use Laravilt\Tables\ApiColumn;

ApiColumn::make('price')->type('decimal')->sortable();
ApiColumn::make('category.name')->type('string')->description('Category name');
ApiColumn::make('password')->writeOnly();
ApiColumn::make('id')->notWritable();
```

## ApiResource Methods

| Method | Description |
|--------|-------------|
| `description()` / `version()` | API documentation metadata |
| `authenticated()` | Require authentication |
| `columns()` | Exposed columns |
| `allowedFilters()` / `allowedSorts()` / `allowedIncludes()` | Query capabilities |
| `paginated()` / `perPage()` | Pagination |
| `rules()` / `createRules()` / `updateRules()` | Validation rules |
| `list()`, `show()`, `create()`, `update()`, `delete()`, `bulkDelete()` | Enable/disable operations, with optional middleware |
| `actions()` | Custom [API actions](api-actions.md) |
| `useAPITester()` | Show the interactive API tester |

## Related

- [API Actions](api-actions.md): custom endpoints
- [Tables API](../../tables/README.md)
