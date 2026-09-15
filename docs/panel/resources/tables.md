---
title: Resource Tables
description: Configure the table shown on a resource's list page.
order: 2
---

# Resource Tables

A resource's `table()` defines the columns, filters and actions on its list page.

## Basic Table

```php
<?php

namespace App\Laravilt\Admin\Resources\User;

use App\Models\User;
use Laravilt\Actions\BulkActionGroup;
use Laravilt\Actions\DeleteAction;
use Laravilt\Actions\DeleteBulkAction;
use Laravilt\Actions\EditAction;
use Laravilt\Actions\ViewAction;
use Laravilt\Panel\Resources\Resource;
use Laravilt\Tables\Columns\TextColumn;
use Laravilt\Tables\Filters\SelectFilter;
use Laravilt\Tables\Table;

class UserResource extends Resource
{
    protected static string $model = User::class;

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
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
```

The generator puts the table in `Table/UserTable.php` and the resource delegates to it. If the database table has a `deleted_at` column, the generator also adds soft-delete support (trashed filter and restore actions).

## Scoping the Query

The list page reads records from the resource's `getEloquentQuery()`, which also applies tenant scoping. Override it to change the base query:

```php
use Illuminate\Database\Eloquent\Builder;

public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()->where('is_active', true);
}
```

## Related

- [Tables](../../tables/README.md): columns, filters and table features
- [Actions](../../actions/README.md): record and bulk actions
- [Navigation Badges](../navigation/badges.md): show record counts in the sidebar
