---
title: CRUD Tools
description: Create, update and delete records from AI tool calls.
order: 2
---

# CRUD Tools

## CreateTool

`model()` reads the model's `$fillable` fields and adds a string parameter for each one.

```php
use App\Models\Product;
use Laravilt\AI\Tools\CreateTool;

$tool = CreateTool::make('create_product')
    ->description('Create a new product')
    ->model(Product::class)
    ->fillable(['name', 'description', 'price', 'sku']); // restrict the saved fields
```

## UpdateTool

Adds a required `id` parameter plus the fillable fields.

```php
use Laravilt\AI\Tools\UpdateTool;

$tool = UpdateTool::make('update_product')
    ->description('Update an existing product')
    ->model(Product::class)
    ->fillable(['name', 'price', 'stock']);
```

## DeleteTool

Adds a required `id` parameter. Soft delete is on by default (`$model->delete()`). `forceDelete()` switches to `$model->forceDelete()`.

```php
use Laravilt\AI\Tools\DeleteTool;

$tool = DeleteTool::make('delete_product')
    ->description('Delete a product')
    ->model(Product::class);

$tool = DeleteTool::make('purge_product')
    ->model(Product::class)
    ->forceDelete();
```

## Generated tools

`ResourceAgent::model()` generates all four tools for a model (see [Agents](../agents/README.md)):

```php
use Laravilt\AI\ResourceAgent;

$agent = ResourceAgent::make('product_agent')->model(Product::class);
// query_products, create_Product, update_Product, delete_Product
```

## Methods

| Method | Tools | Description |
|--------|-------|-------------|
| `model(string)` | all | Eloquent model |
| `fillable(array)` | Create, Update | Fields that may be written |
| `softDelete(bool)` | Delete | Soft delete (default `true`) |
| `forceDelete()` | Delete | Permanently delete |
