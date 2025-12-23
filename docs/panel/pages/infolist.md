---
title: Page Infolist
description: Display read-only data on pages using infolists
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
concept: pages
---

# Page Infolist

Display read-only data on pages using infolists.

## Basic Infolist Page

```php
<?php

namespace App\Laravilt\Admin\Pages;

use Laravilt\Panel\Pages\Page;
use Laravilt\Schemas\Schema;
use Laravilt\Infolists\Entries\TextEntry;
use Laravilt\Schemas\Components\Section;

class SystemInfo extends Page
{
    protected static ?string $navigationIcon = 'Info';
    protected static ?string $title = 'System Information';

    public function infolist(Schema $infolist): Schema
    {
        return $infolist->schema([
            Section::make('Application')
                ->schema([
                    TextEntry::make('app_name')
                        ->label('Application Name')
                        ->state(config('app.name')),
                    TextEntry::make('environment')
                        ->label('Environment')
                        ->state(app()->environment()),
                    TextEntry::make('php_version')
                        ->label('PHP Version')
                        ->state(PHP_VERSION),
                    TextEntry::make('laravel_version')
                        ->label('Laravel Version')
                        ->state(app()->version()),
                ]),
        ]);
    }
}
```

## With Columns Layout

```php
<?php

namespace App\Laravilt\Admin\Pages;

use Laravilt\Panel\Pages\Page;
use Laravilt\Schemas\Schema;
use Laravilt\Schemas\Components\Section;
use Laravilt\Infolists\Entries\TextEntry;
use Laravilt\Infolists\Entries\IconEntry;

class ServerStatus extends Page
{
    protected static ?string $navigationIcon = 'Server';

    public function infolist(Schema $infolist): Schema
    {
        return $infolist->schema([
            Section::make('Server Status')
                ->columns(2)
                ->schema([
                    TextEntry::make('uptime')
                        ->label('Uptime')
                        ->state($this->getUptime()),
                    TextEntry::make('memory')
                        ->label('Memory Usage')
                        ->state($this->getMemoryUsage()),
                    IconEntry::make('database')
                        ->label('Database')
                        ->boolean()
                        ->state($this->isDatabaseHealthy()),
                    IconEntry::make('cache')
                        ->label('Cache')
                        ->boolean()
                        ->state($this->isCacheHealthy()),
                ]),
        ]);
    }
}
```

## User Profile Page

```php
<?php

namespace App\Laravilt\Admin\Pages;

use Laravilt\Panel\Pages\Page;
use Laravilt\Schemas\Schema;
use Laravilt\Schemas\Components\Section;
use Laravilt\Infolists\Entries\TextEntry;
use Laravilt\Infolists\Entries\ImageEntry;

class Profile extends Page
{
    protected static ?string $navigationIcon = 'User';
    protected static ?string $title = 'My Profile';

    public function infolist(Schema $infolist): Schema
    {
        $user = auth()->user();

        return $infolist->schema([
            Section::make('Profile Information')
                ->columns(2)
                ->schema([
                    ImageEntry::make('avatar')
                        ->label('Avatar')
                        ->circular()
                        ->state($user->avatar_url),
                    TextEntry::make('name')
                        ->label('Name')
                        ->state($user->name),
                    TextEntry::make('email')
                        ->label('Email')
                        ->state($user->email),
                    TextEntry::make('created_at')
                        ->label('Member Since')
                        ->dateTime()
                        ->state($user->created_at),
                ]),
        ]);
    }
}
```
