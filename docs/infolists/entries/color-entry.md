---
title: ColorEntry
description: Color swatches with an optional label and copy button.
order: 5
---

# ColorEntry

Displays a color swatch.

```php
use Laravilt\Infolists\Entries\ColorEntry;

ColorEntry::make('brand_color')
    ->showLabel()   // show the color value
    ->size('lg')    // xs, sm, md, lg, xl
    ->copyable();
```

## API reference

| Method | Description |
|--------|-------------|
| `showLabel(bool)` | Show the color value |
| `size(string)` | Swatch size |
| `copyable(bool)` | Copy button |
