---
title: Resources
description: CRUD screens for Eloquent models, built from forms, tables and infolists.
order: 7
---

# Resources

Resources are the core building blocks of a panel. Each one represents CRUD screens for an Eloquent model: a list page (table), create and edit pages (form), and a view page (infolist).

## Creating a Resource

```bash
php artisan laravilt:resource
```

The command asks for the panel and the database table, then generates the resource from the table's columns. You can pass everything up front:

```bash
php artisan laravilt:resource Admin --table=users --model=User
php artisan laravilt:resource Admin --table=tags --simple   # single ManageRecords page with modals
```

| Argument / option | Description |
|-------------------|-------------|
| `panel` | Target panel (prompted if omitted) |
| `--table=` | Database table to generate from |
| `--model=` | Model class name |
| `--simple` | Generate one `Manage{Model}` page instead of List/Create/Edit/View |

For a `users` table in the `Admin` panel it generates:

```
app/Laravilt/Admin/Resources/User/
├── UserResource.php
├── Form/UserForm.php
├── Table/UserTable.php
├── InfoList/UserInfoList.php
└── Pages/        # List, Create, Edit and View pages
```

If you enable them, it also creates `Api/UserApi.php` and `Ai/UserAi.php`.

## Basic Resource

```php
<?php

namespace App\Laravilt\Admin\Resources\User;

use App\Models\User;
use Laravilt\AI\AIAgent;
use Laravilt\Panel\Resources\Resource;
use Laravilt\Schemas\Schema;
use Laravilt\Tables\ApiResource;
use Laravilt\Tables\Table;

class UserResource extends Resource
{
    protected static string $model = User::class;

    protected static ?string $navigationIcon = 'Users';

    protected static ?string $navigationGroup = 'System';

    protected static int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([/* fields */]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->schema([/* entries */]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([/* columns */]);
    }

    public static function api(ApiResource $api): ApiResource
    {
        return $api->columns([/* api columns */]);
    }

    public static function ai(AIAgent $agent): AIAgent
    {
        return $agent->columns([/* ai columns */])->canQuery();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
```

> `$model` is typed `string` and `$navigationSort` is typed `int` on the base class. Redeclare them with the same types (`?string` / `?int` cause a PHP fatal error).

## Labels & Slug

```php
class UserResource extends Resource
{
    protected static ?string $label = 'Member';

    protected static ?string $pluralLabel = 'Team Members';

    protected static ?string $slug = 'members';   // URL: /admin/members
}
```

Override `getLabel()`, `getPluralLabel()` or `getNavigationLabel()` for translated labels:

```php
public static function getNavigationLabel(): string
{
    return __('Users');
}
```

## In this section

1. [Resource Forms](forms.md): create/edit forms and view infolists
2. [Resource Tables](tables.md): list page tables
3. [Authorization](authorization.md): permission checks
4. [Relation Managers](relation-managers.md): manage related records
5. [Nested Resources](nested-resources.md): child resources under a parent
6. [Resource API](api.md): REST endpoints
7. [API Actions](api-actions.md): custom API endpoints
8. [Resource AI](ai.md): AI agents and global search
9. [AI Columns](ai-columns.md): columns the AI can use
