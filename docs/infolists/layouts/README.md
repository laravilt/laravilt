---
title: Layouts
description: Organize infolist entries with Section, Grid and Tabs.
order: 2
---

# Layouts

Infolists use the layout components from [Schemas](../../schemas/components/README.md). The infolist renderer supports Section, Grid and Tabs:

1. [Section](section.md): grouped entries with a heading
2. [Grid](grid.md): column layouts
3. [Tabs](tabs.md): tabbed panels

```php
use Laravilt\Infolists\Entries\TextEntry;
use Laravilt\Schemas\Components\Grid;
use Laravilt\Schemas\Components\Section;
use Laravilt\Schemas\Components\Tab;
use Laravilt\Schemas\Components\Tabs;

Section::make('Details')
    ->schema([
        Grid::make(2)->schema([
            TextEntry::make('name'),
            TextEntry::make('email'),
        ]),
        Tabs::make('more')->tabs([
            Tab::make('Profile')->schema([TextEntry::make('bio')]),
            Tab::make('Settings')->schema([TextEntry::make('timezone')]),
        ]),
    ]);
```
