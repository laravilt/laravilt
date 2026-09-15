---
title: BadgeEntry
description: Badges with value-based colors and icons.
order: 2
---

# BadgeEntry

Displays a value as a badge, with colors and icons that depend on the value.

```php
use Laravilt\Infolists\Entries\BadgeEntry;

BadgeEntry::make('status')
    ->colors([
        'draft' => 'gray',
        'pending' => 'warning',
        'approved' => 'success',
        'rejected' => 'danger',
    ])
    ->icons([
        'pending' => 'Clock',
        'approved' => 'CheckCircle',
    ]);

BadgeEntry::make('score')
    ->color(fn (int $state): string => $state >= 90 ? 'success' : 'warning');

BadgeEntry::make('is_active')->bool();
```

## API reference

| Method | Description |
|--------|-------------|
| `colors(array)` | Value-to-color map |
| `icons(array)` | Value-to-icon map |
| `color(string\|Closure)` | Single or computed color |
| `bool(trueIcon, falseIcon)` | Boolean display |
