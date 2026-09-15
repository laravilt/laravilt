---
title: ColorColumn
description: Display color swatches with optional copy to clipboard.
order: 4
---

# ColorColumn

```php
use Laravilt\Tables\Columns\ColorColumn;

ColorColumn::make('color')
    ->label('Brand color');
```

## Copyable

```php
ColorColumn::make('hex_color')
    ->copyable()
    ->copyMessage('Color copied!')
    ->copyMessageDuration(1500);
```

## Multiple colors

For attributes holding several colors:

```php
ColorColumn::make('palette')
    ->wrap()
    ->maxVisible(5);
```

## API reference

| Method | Description |
|--------|-------------|
| `copyable()` | Copy the value on click |
| `copyMessage()`, `copyMessageDuration()` | Copy feedback |
| `wrap()` | Wrap multiple swatches |
| `maxVisible()` | Maximum swatches shown |
