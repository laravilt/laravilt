---
title: Relation Managers
description: Manage related records from inside a resource's view or edit page.
order: 4
---

# Relation Managers

Relation managers let you manage related records directly on a resource's view or edit page.

## Creating a Relation Manager

```bash
php artisan laravilt:relation
```

The command asks for the panel, the resource and the relationship. You can also pass them as arguments:

```bash
php artisan laravilt:relation Admin Category products
```

This creates `app/Laravilt/Admin/Resources/Category/RelationManagers/ProductsRelationManager.php`.

## Basic Structure

```php
<?php

namespace App\Laravilt\Admin\Resources\Category\RelationManagers;

use Laravilt\Actions\DeleteAction;
use Laravilt\Actions\EditAction;
use Laravilt\Forms\Components\TextInput;
use Laravilt\Panel\Resources\RelationManagers\RelationManager;
use Laravilt\Schemas\Schema;
use Laravilt\Tables\Columns\TextColumn;
use Laravilt\Tables\Table;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $label = 'Product';

    protected static ?string $pluralLabel = 'Products';

    protected static ?string $icon = 'Package';

    public function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('name')
                ->required()
                ->maxLength(255),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
```

## Registering in the Resource

```php
use App\Laravilt\Admin\Resources\Category\RelationManagers\ProductsRelationManager;

public static function getRelations(): array
{
    return [
        ProductsRelationManager::class,
    ];
}
```

## Properties & Methods

| Member | Description |
|--------|-------------|
| `$relationship` | Eloquent relationship name on the owner model |
| `$recordTitleAttribute` | Attribute used as the record title |
| `$label` / `$pluralLabel` | Singular and plural labels |
| `$icon` | Lucide icon |
| `isReadOnly()` | Return `true` to disable create/edit/delete |
| `canCreate()`, `canEdit()`, `canDelete()` | Per-operation checks |
| `getHeaderActions()` | Actions above the relation table |

## Related

- [Nested Resources](nested-resources.md): full child resources with their own pages
