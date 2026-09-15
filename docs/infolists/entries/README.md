---
title: Entries
description: The eight infolist entry types and the methods they share.
order: 1
---

# Entries

| Entry | Description |
|-------|-------------|
| [TextEntry](text-entry.md) | Text with formatting |
| [BadgeEntry](badge-entry.md) | Badges with colors and icons |
| [IconEntry](icon-entry.md) | Lucide icons and booleans |
| [ImageEntry](image-entry.md) | Images and avatars |
| [ColorEntry](color-entry.md) | Color swatches |
| [CodeEntry](code-entry.md) | Syntax-highlighted code |
| [KeyValueEntry](key-value-entry.md) | Key-value tables |
| [RepeatableEntry](repeatable-entry.md) | Collections with nested entries |

## Shared methods

All entries extend `Laravilt\Infolists\Entries\Entry`:

```php
use Laravilt\Infolists\Entries\TextEntry;

TextEntry::make('name')
    ->label('Full Name')
    ->icon('User')
    ->iconColor('primary')
    ->color('gray')
    ->copyable()
    ->placeholder('Not provided')
    ->formatStateUsing(fn ($state) => strtoupper($state))
    ->visible(fn ($record) => $record->is_public)
    ->columnSpan(2);
```

Dot notation reads relationships, for example `TextEntry::make('author.name')`.
