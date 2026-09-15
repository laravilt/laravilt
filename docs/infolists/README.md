---
title: Infolists
description: Read-only display of record data with typed entries and layouts.
order: 7
---

# Infolists

The `laravilt/infolists` package displays record data read-only, for example on a resource's View page. You describe entries in PHP, and Vue or React renders them.

> React support requires Laravilt v1.1 or later.

## Basic usage

In a resource, define the static `infolist()` method:

```php
use Laravilt\Infolists\Entries\ImageEntry;
use Laravilt\Infolists\Entries\TextEntry;
use Laravilt\Schemas\Components\Section;
use Laravilt\Schemas\Schema;

public static function infolist(Schema $schema): Schema
{
    return $schema->schema([
        Section::make('Profile')
            ->columns(2)
            ->schema([
                ImageEntry::make('avatar')->circular(),
                TextEntry::make('name'),
                TextEntry::make('email')->copyable(),
                TextEntry::make('created_at')->dateTime(),
            ]),
    ]);
}
```

To generate a standalone infolist class, run `php artisan make:infolist UserInfolist`. It creates `app/Infolists/UserInfolist.php`.

## Sections

1. [Entries](entries/README.md): the eight entry types
2. [Layouts](layouts/README.md): Section, Grid and Tabs for entries
3. [Custom Entries](custom/README.md): build your own entry types

## Related

- [Schemas](../schemas/README.md)
- [Forms](../forms/README.md)
