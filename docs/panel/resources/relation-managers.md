---
title: Relation Managers
description: Manage related records within a resource
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
concept: resources
---

# Relation Managers

Relation Managers allow you to manage related records directly within a resource's view or edit page.

## Creating a Relation Manager

```bash
php artisan laravilt:relation-manager CategoryResource products
```

## Basic Structure

```php
<?php

namespace App\Laravilt\Admin\Resources\Category\RelationManagers;

use Laravilt\Panel\Resources\RelationManagers\RelationManager;
use Laravilt\Schemas\Schema;
use Laravilt\Tables\Table;
use Laravilt\Tables\Columns\TextColumn;
use Laravilt\Forms\Components\TextInput;

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
            ->defaultSort('name')
            ->searchable()
            ->paginated([10, 25, 50]);
    }
}
```

## Registering in Resource

```php
<?php

namespace App\Laravilt\Admin\Resources\Category;

use App\Laravilt\Admin\Resources\Category\RelationManagers\ProductsRelationManager;
use Laravilt\Panel\Resources\Resource;

class CategoryResource extends Resource
{
    public static function getRelations(): array
    {
        return [
            ProductsRelationManager::class,
        ];
    }
}
```

## Properties

| Property | Type | Description |
|----------|------|-------------|
| `$relationship` | `string` | Eloquent relationship name |
| `$recordTitleAttribute` | `string` | Attribute for record title |
| `$label` | `string` | Singular label |
| `$pluralLabel` | `string` | Plural label |
| `$icon` | `string` | Lucide icon |
