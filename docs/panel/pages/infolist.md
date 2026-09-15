---
title: Page Infolists
description: Display read-only data on a custom page with infolist entries.
order: 3
---

# Page Infolists

Return infolist entries from `getSchema()` to show read-only data. Set each entry's value with `state()`.

## Basic Infolist Page

```php
<?php

namespace App\Laravilt\Admin\Pages;

use Laravilt\Infolists\Entries\TextEntry;
use Laravilt\Panel\Pages\Page;
use Laravilt\Schemas\Components\Section;

class SystemInfo extends Page
{
    protected static ?string $navigationIcon = 'Info';

    protected static ?string $title = 'System Information';

    protected function getSchema(): array
    {
        return [
            Section::make('Application')
                ->columns(2)
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
        ];
    }
}
```

## Status Page with Icons and Images

```php
<?php

namespace App\Laravilt\Admin\Pages;

use Illuminate\Support\Facades\DB;
use Laravilt\Infolists\Entries\IconEntry;
use Laravilt\Infolists\Entries\ImageEntry;
use Laravilt\Infolists\Entries\TextEntry;
use Laravilt\Panel\Pages\Page;
use Laravilt\Schemas\Components\Section;

class MyAccount extends Page
{
    protected static ?string $navigationIcon = 'User';

    protected function getSchema(): array
    {
        $user = auth()->user();

        return [
            Section::make('Profile')
                ->columns(2)
                ->schema([
                    ImageEntry::make('avatar')
                        ->circular()
                        ->state($user->avatar_url),
                    TextEntry::make('name')->state($user->name),
                    TextEntry::make('email')->state($user->email),
                    TextEntry::make('created_at')
                        ->label('Member Since')
                        ->dateTime()
                        ->state($user->created_at),
                    IconEntry::make('database')
                        ->label('Database reachable')
                        ->boolean()
                        ->state(rescue(fn () => (bool) DB::select('select 1'), false)),
                ]),
        ];
    }
}
```

## Related

- [Infolists](../../infolists/README.md): all entry types
