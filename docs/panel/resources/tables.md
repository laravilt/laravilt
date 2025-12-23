---
title: Resource Tables
description: Configure tables for resource listing pages
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
concept: resources
---

# Resource Tables

Configure tables for resource listing pages.

## Basic Table

```php
<?php

namespace App\Laravilt\Admin\Resources\User;

use App\Models\User;
use Laravilt\Panel\Resources\Resource;
use Laravilt\Tables\Table;
use Laravilt\Tables\Columns\TextColumn;
use Laravilt\Tables\Filters\SelectFilter;
use Laravilt\Actions\ViewAction;
use Laravilt\Actions\EditAction;
use Laravilt\Actions\DeleteAction;
use Laravilt\Actions\DeleteBulkAction;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'user' => 'User',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }
}
```

## Navigation Badge

```php
<?php

namespace App\Laravilt\Admin\Resources\Order;

use Laravilt\Panel\Resources\Resource;

class OrderResource extends Resource
{
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'warning' : 'success';
    }
}
```
