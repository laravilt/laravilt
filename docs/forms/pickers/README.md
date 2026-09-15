---
title: Pickers
description: Color, icon, tags, slider and rating fields.
order: 4
---

# Pickers

Specialized fields for picking a value.

| Component | Description |
|-----------|-------------|
| [ColorPicker](color-picker.md) | Color with swatches and formats |
| [IconPicker](icon-picker.md) | Lucide icon selection |
| [TagsInput](tags-input.md) | Free-form tags with suggestions |
| [Slider](slider.md) | Numeric range slider |
| [RateInput](rate-input.md) | Star rating |

```php
use Laravilt\Forms\Components\ColorPicker;
use Laravilt\Forms\Components\IconPicker;
use Laravilt\Forms\Components\Slider;
use Laravilt\Forms\Components\TagsInput;

ColorPicker::make('brand_color')->default('#3b82f6');
IconPicker::make('icon')->searchable();
TagsInput::make('tags')->suggestions(['php', 'laravel'])->maxTags(5);
Slider::make('volume')->min(0)->max(100);
```
