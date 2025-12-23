---
title: Resources
description: CRUD entities with forms, tables, and infolists
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
concept: resources
---

# Resources

Resources are the core building blocks of Laravilt panels, representing CRUD entities.

## Creating a Resource

```bash
php artisan laravilt:resource User
```

This generates:
- `UserResource.php` - Resource class
- `Pages/ListUsers.php` - Index page
- `Pages/CreateUser.php` - Create page
- `Pages/EditUser.php` - Edit page
- `Pages/ViewUser.php` - View page

## Basic Resource

```php
<?php

namespace App\Laravilt\Admin\Resources\User;

use App\Models\User;
use Laravilt\Panel\Resources\Resource;
use Laravilt\Schemas\Schema;
use Laravilt\Tables\Table;
use Laravilt\Tables\ApiResource;
use Laravilt\AI\AIAgent;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'Users';
    protected static ?string $navigationGroup = 'System';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $form): Schema
    {
        return $form->schema([...]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([...])->filters([...])->recordActions([...]);
    }

    public static function api(ApiResource $api): ApiResource
    {
        return $api->columns([...])->allowedFilters([...])->allowedSorts([...]);
    }

    public static function ai(AIAgent $agent): AIAgent
    {
        return $agent->columns([...])->canQuery(true)->canCreate(true);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUsers::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}'),
        ];
    }
}
```

## Navigation Properties

```php
use Laravilt\Panel\Resources\Resource;

class UserResource extends Resource
{
    protected static ?string $navigationIcon = 'Users';
    protected static ?string $navigationLabel = 'Team Members';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __('Users');
    }
}
```

## Model Configuration

```php
use Laravilt\Panel\Resources\Resource;

class PostResource extends Resource
{
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $slug = 'posts';
    protected static bool $hasSoftDeletes = true;
}
```

## Related

- [Forms](forms) - Form configuration
- [Tables](tables) - Table configuration
- [Authorization](authorization) - Authorization methods
- [Relation Managers](relation-managers) - Manage related records
- [Nested Resources](nested-resources) - Child resources under parents
- [API](api) - REST API endpoints
- [AI](ai) - AI-powered operations
