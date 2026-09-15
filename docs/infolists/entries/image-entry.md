---
title: ImageEntry
description: Images and avatars, including stacked groups and fallbacks.
order: 4
---

# ImageEntry

Displays images and avatars.

```php
use Laravilt\Infolists\Entries\ImageEntry;

ImageEntry::make('avatar')
    ->circular()
    ->size(80)
    ->defaultImageUrl('/images/default-avatar.png');

ImageEntry::make('photo')->rounded()->width(320)->height(200)->alt('Product photo');

ImageEntry::make('team_photos')
    ->stacked()
    ->limit(4)
    ->ring(2)
    ->overlap(4);
```

## API reference

| Method | Description |
|--------|-------------|
| `size(int)` / `width(int)` / `height(int)` | Dimensions |
| `circular(bool)` / `rounded(bool)` | Shape |
| `alt(string)` | Alt text |
| `defaultImageUrl(string\|Closure)` / `defaultImage(string)` | Fallback image |
| `stacked(bool)` / `limit(int)` / `ring(int)` / `overlap(int)` | Multiple images |
