---
title: ColorPicker
description: Color selection with formats, alpha, swatches and multiple colors.
order: 1
---

# ColorPicker

Color selection in a popover.

## Basic usage

```php
use Laravilt\Forms\Components\ColorPicker;

ColorPicker::make('color')
    ->label('Brand Color');
```

## Format and alpha

```php
ColorPicker::make('primary_color')->format('hex'); // hex, rgb or hsl
ColorPicker::make('overlay')->format('rgb')->alpha();
```

## Swatches

```php
ColorPicker::make('theme_color')
    ->swatches(['#3b82f6', '#ef4444', '#22c55e', '#f59e0b']);
```

## Multiple colors

```php
ColorPicker::make('palette')
    ->multiple()
    ->minItems(2)
    ->maxItems(5)
    ->popupPosition('bottom-end');
```

## API reference

| Method | Description |
|--------|-------------|
| `format(string)` | `hex`, `rgb` or `hsl` |
| `alpha(bool)` | Alpha channel control |
| `swatches(array)` | Preset colors |
| `multiple(bool)` / `minItems()` / `maxItems()` | Multiple colors |
| `popupPosition(string)` | e.g. `bottom-start`, `top`, `right-end` |
