---
title: Resource Forms
description: Configure forms for resource create and edit pages
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
concept: resources
---

# Resource Forms

Configure forms for resource create and edit pages.

## Basic Form

```php
<?php

namespace App\Laravilt\Admin\Resources\User;

use App\Models\User;
use Laravilt\Panel\Resources\Resource;
use Laravilt\Schemas\Schema;
use Laravilt\Schemas\Components\Section;
use Laravilt\Forms\Components\TextInput;
use Laravilt\Forms\Components\Select;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            Section::make('User Information')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->required(),
                    TextInput::make('email')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true),
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

## Infolist Configuration

```php
<?php

namespace App\Laravilt\Admin\Resources\User;

use Laravilt\Panel\Resources\Resource;
use Laravilt\Schemas\Schema;
use Laravilt\Schemas\Components\Section;
use Laravilt\Infolists\Entries\TextEntry;

class UserResource extends Resource
{
    public static function infolist(Schema $infolist): Schema
    {
        return $infolist->schema([
            Section::make('User Information')
                ->schema([
                    TextEntry::make('name'),
                    TextEntry::make('email'),
                    TextEntry::make('created_at')->dateTime(),
                ]),
        ]);
    }
}
```

## Global Search

```php
<?php

namespace App\Laravilt\Admin\Resources\User;

use Laravilt\Panel\Resources\Resource;

class UserResource extends Resource
{
    protected static ?string $recordTitleAttribute = 'name';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        return [
            'Email' => $record->email,
        ];
    }
}
```
