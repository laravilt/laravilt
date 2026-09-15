---
title: API Actions
description: Add custom endpoints to a resource's REST API.
order: 7
---

# API Actions

Add custom endpoints to a resource API with `ApiAction`.

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
    ->patch()
    ->requiresRecord()
    ->rules(['quantity' => 'required|integer|min:0'])
    ->fields([
        ApiColumn::make('quantity')->type('integer')->description('New stock quantity'),
    ])
    ->action(function ($record, $request) {
        $record->update(['stock' => $request->input('quantity')]);

        return ['stock' => $record->stock];
    });
```

## Bulk Action

```php
ApiAction::make('bulk-publish')
    ->label('Bulk Publish')
    ->post()
    ->bulk()
    ->requiresConfirmation(message: 'Publish all selected products?')
    ->action(function ($record, $request) {
        $record->update(['status' => 'published']);

        return ['status' => 'published'];
    });
```

## Collection Action (No Record)

```php
use App\Models\Product;

ApiAction::make('statistics')
    ->label('Get Statistics')
    ->get()
    ->requiresRecord(false)
    ->action(fn ($record, $request) => [
        'total_products' => Product::count(),
        'published' => Product::where('status', 'published')->count(),
    ]);
```

## ApiAction Methods

| Method | Description |
|--------|-------------|
| `make()`, `slug()`, `label()`, `description()` | Identity and docs |
| `icon()`, `color()` | Display |
| `get()`, `post()`, `put()`, `patch()`, `delete()`, `method()` | HTTP method |
| `requiresRecord()` | Needs a record id in the URL |
| `bulk()` | Operates on multiple records |
| `rules()`, `fields()` | Validation and input fields |
| `requiresConfirmation()` / `confirmable()` | Confirmation prompt |
| `before()`, `after()` | Hooks around the action |
| `successMessage()`, `errorMessage()` | Result messages |
| `hidden()` | Hide the action |
| `action()` | Callback receiving `($record, $request)` |
