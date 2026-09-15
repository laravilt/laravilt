---
title: Nested Resources
description: Scope a child resource under a parent resource with hierarchical URLs.
order: 5
---

# Nested Resources

A nested resource is a full resource (list, create, edit, view) scoped to one parent record, for example `/admin/customers/{customer}/tags`.

## Creating a Nested Resource

```bash
php artisan laravilt:nested Tag --parent=Customer
```

| Argument / option | Description |
|-------------------|-------------|
| `name` | Nested resource name (e.g. `Tag`) |
| `--parent=` | Parent resource name (e.g. `Customer`) |
| `--model=` | Model class (defaults to the name) |
| `--panel=Admin` | Panel name |
| `--simple` | Single `ManageRecords` page |
| `--force` | Overwrite existing files |

The parent resource must already exist at `app/Laravilt/{Panel}/Resources/{Parent}/{Parent}Resource.php`. The command also adds the new class to the parent's `getNestedResources()`.

## Nested Resource

```php
<?php

namespace App\Laravilt\Admin\Resources\Customer\Tag;

use App\Laravilt\Admin\Resources\Customer\CustomerResource;
use App\Models\Tag;
use Laravilt\Panel\Resources\NestedResource;

class TagResource extends NestedResource
{
    protected static string $model = Tag::class;

    protected static ?string $parentResource = CustomerResource::class;

    // Relationship on the child model that points to the parent
    protected static string $parentRelationship = 'customer';
}
```

## Parent Resource

```php
class CustomerResource extends Resource
{
    public static function getNestedResources(): array
    {
        return [
            Tag\TagResource::class,
        ];
    }
}
```

Nested resources are registered through their parent. Don't add them to the panel yourself.

## URL Structure

```
/admin/customers/{customer}/tags            # List
/admin/customers/{customer}/tags/create     # Create
/admin/customers/{customer}/tags/{record}   # View
```

## Accessing the Parent Record

```php
$customer = TagResource::getParentRecord();
$customerId = TagResource::getParentRecordId();
```

Queries are scoped to the parent automatically through `modifyQueryForParent()`.

## Properties

| Property | Type | Description |
|----------|------|-------------|
| `$parentResource` | `?string` | Parent resource class |
| `$parentRelationship` | `string` | Relationship from child to parent |
| `$childRelationship` | `?string` | Relationship from parent to children (optional) |
| `$showInParentNavigation` | `bool` | Show a link in the parent's sub-navigation (default `true`) |
