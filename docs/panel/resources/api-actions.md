---
title: API Actions
description: Add custom actions to resource API endpoints
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
concept: resources
---

# API Actions

Add custom actions to your resource API endpoints.

## Basic Action

```php
<?php

namespace App\Laravilt\Admin\Resources\Product;

use Laravilt\Panel\Resources\Resource;
use Laravilt\Tables\ApiAction;
use Laravilt\Tables\ApiResource;

class ProductResource extends Resource
{
    public static function api(ApiResource $api): ApiResource
    {
        return $api->actions([
            ApiAction::make('publish')
                ->label('Publish')
                ->description('Publish a product')
                ->icon('Eye')
                ->color('success')
                ->post()
                ->requiresRecord()
                ->successMessage('Product published successfully')
                ->action(function ($record, $request) {
                    $record->update(['status' => 'published']);
                    return ['status' => 'published', 'product' => $record];
                }),
        ]);
    }
}
```

## Action with Validation

```php
use Laravilt\Tables\ApiAction;
use Laravilt\Tables\ApiColumn;

ApiAction::make('update-stock')
    ->label('Update Stock')
    ->description('Update product stock quantity')
    ->icon('Package')
    ->color('primary')
    ->patch()
    ->requiresRecord()
    ->rules(['quantity' => 'required|integer|min:0'])
    ->fields([
        ApiColumn::make('quantity')->type('integer')->label('New Stock Quantity'),
    ])
    ->successMessage('Stock updated successfully')
    ->action(function ($record, $request) {
        $record->update(['stock' => $request->input('quantity')]);
        return ['stock' => $record->stock, 'product' => $record];
    });
```

## Bulk Action

```php
use Laravilt\Tables\ApiAction;

ApiAction::make('bulk-publish')
    ->label('Bulk Publish')
    ->description('Publish multiple products at once')
    ->icon('Eye')
    ->color('success')
    ->post()
    ->bulk()
    ->successMessage('Products published successfully')
    ->action(function ($record, $request) {
        $record->update(['status' => 'published']);
        return ['status' => 'published'];
    });
```

## Collection Action (No Record)

```php
use Laravilt\Tables\ApiAction;

ApiAction::make('statistics')
    ->label('Get Statistics')
    ->description('Get product statistics')
    ->icon('BarChart')
    ->color('info')
    ->get()
    ->requiresRecord(false)
    ->action(function ($record, $request) {
        return [
            'total_products' => Product::count(),
            'published' => Product::where('status', 'published')->count(),
        ];
    });
```

## API Action Methods

| Method | Description |
|--------|-------------|
| `make()` | Create action |
| `label()` | Action label |
| `description()` | Action description |
| `icon()` | Lucide icon |
| `color()` | Color theme |
| `get()` / `post()` / `patch()` | HTTP method |
| `requiresRecord()` | Needs record context |
| `bulk()` | Bulk action |
| `rules()` | Validation rules |
| `fields()` | Input fields |
| `confirmable()` | Confirmation message |
| `successMessage()` | Success notification |
| `action()` | Action callback |
