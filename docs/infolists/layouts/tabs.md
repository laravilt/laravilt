---
title: Tabs
description: Organize infolist entries into tabbed panels.
order: 3
---

# Tabs

Organizes entries into tabbed panels.

```php
use Laravilt\Infolists\Entries\TextEntry;
use Laravilt\Schemas\Components\Tab;
use Laravilt\Schemas\Components\Tabs;

Tabs::make('user')
    ->tabs([
        Tab::make('Profile')
            ->icon('User')
            ->schema([
                TextEntry::make('name'),
                TextEntry::make('bio'),
            ]),
        Tab::make('Notifications')
            ->icon('Bell')
            ->badge('5')
            ->schema([
                TextEntry::make('email_frequency'),
            ]),
    ]);
```

See [Tabs](../../schemas/components/tabs.md) for the full API.
