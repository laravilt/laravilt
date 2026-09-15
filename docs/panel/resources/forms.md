---
title: Resource Forms
description: Configure the form used on create and edit pages and the infolist used on view pages.
order: 1
---

# Resource Forms

A resource's `form()` defines the fields on its create and edit pages, and `infolist()` defines what the view page shows.

## Basic Form

```php
<?php

namespace App\Laravilt\Admin\Resources\User;

use App\Models\User;
use Laravilt\Forms\Components\Select;
use Laravilt\Forms\Components\TextInput;
use Laravilt\Panel\Resources\Resource;
use Laravilt\Schemas\Components\Section;
use Laravilt\Schemas\Schema;

class UserResource extends Resource
{
    protected static string $model = User::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('User Information')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->required(),
                    TextInput::make('email')
                        ->email()
                        ->required(),
                    Select::make('role')
                        ->options([
                            'admin' => 'Admin',
                            'user' => 'User',
                        ]),
                ]),
        ]);
    }
}
```

## Separate Form Classes

The generator puts the form in its own class (`Form/UserForm.php`) and the resource delegates to it:

```php
use App\Laravilt\Admin\Resources\User\Form\UserForm;

public static function form(Schema $schema): Schema
{
    return UserForm::configure($schema);
}
```

## Infolist

```php
use Laravilt\Infolists\Entries\TextEntry;
use Laravilt\Schemas\Components\Section;
use Laravilt\Schemas\Schema;

public static function infolist(Schema $schema): Schema
{
    return $schema->schema([
        Section::make('User Information')
            ->schema([
                TextEntry::make('name'),
                TextEntry::make('email'),
                TextEntry::make('created_at')->dateTime(),
            ]),
    ]);
}
```

## Global Search

Global search is enabled per panel with `->globalSearch()`. It searches every resource that has an [AI agent](ai.md) with `searchable()` columns:

```php
public static function ai(AIAgent $agent): AIAgent
{
    return $agent->searchable(['name', 'email']);
}
```

## Related

- [Forms](../../forms/README.md): all field types
- [Schemas](../../schemas/README.md): sections, grids, tabs
- [Infolists](../../infolists/README.md): all entry types
