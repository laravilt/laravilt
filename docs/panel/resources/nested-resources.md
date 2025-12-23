---
title: Nested Resources
description: Create child resources under parent resources
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
concept: resources
---

# Nested Resources

Nested resources allow you to scope child resources under a parent resource, creating hierarchical URL structures.

## Creating a Nested Resource

```bash
php artisan laravilt:resource Order/OrderItem --nested
```

## Parent Resource

```php
<?php

namespace App\Laravilt\Admin\Resources\Order;

use App\Models\Order;
use Laravilt\Panel\Resources\Resource;

class OrderResource extends Resource
{
    protected static string $model = Order::class;

    protected static ?string $navigationIcon = 'ShoppingCart';

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'items' => Pages\ManageOrderItems::route('/{record}/items'),
        ];
    }
}
```

## Nested Resource

```php
<?php

namespace App\Laravilt\Admin\Resources\Order;

use App\Models\OrderItem;
use Laravilt\Panel\Resources\Resource;

class OrderItemResource extends Resource
{
    protected static string $model = OrderItem::class;

    protected static ?string $parentResource = OrderResource::class;

    protected static ?string $parentRelationship = 'items';

    protected static bool $shouldRegisterNavigation = false;
}
```

## URL Structure

With nested resources, URLs follow this pattern:

```
/admin/orders/{order}/items          # List items
/admin/orders/{order}/items/create   # Create item
/admin/orders/{order}/items/{item}   # View item
```

## Accessing Parent Record

```php
<?php

namespace App\Laravilt\Admin\Resources\Order\Pages;

use Laravilt\Panel\Resources\Pages\ListRecords;

class ManageOrderItems extends ListRecords
{
    public function getParentRecord()
    {
        return $this->getOwnerRecord();
    }

    protected function getTableQuery()
    {
        return parent::getTableQuery()
            ->where('order_id', $this->getOwnerRecord()->id);
    }
}
```

## Properties

| Property | Type | Description |
|----------|------|-------------|
| `$parentResource` | `string` | Parent resource class |
| `$parentRelationship` | `string` | Eloquent relationship name |
| `$shouldRegisterNavigation` | `bool` | Usually `false` for nested |
