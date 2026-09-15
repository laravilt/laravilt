---
title: Section
description: Group infolist entries under a heading.
order: 1
---

# Section

Groups entries under a heading, with an optional description, icon and collapse.

```php
use Laravilt\Infolists\Entries\TextEntry;
use Laravilt\Schemas\Components\Section;

Section::make('Contact Details')
    ->description('Primary contact information')
    ->icon('Phone')
    ->columns(2)
    ->collapsible()
    ->schema([
        TextEntry::make('phone'),
        TextEntry::make('address'),
    ]);
```

See [Section](../../schemas/components/section.md) for the full API.
