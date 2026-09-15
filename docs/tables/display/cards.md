---
title: Cards
description: Configure card layouts for the table grid view.
order: 3
---

# Cards

`Laravilt\Tables\Card` describes how each record renders in [grid view](grid-view.md).

## Presets

```php
use Laravilt\Tables\Card;

// Image, title, price, description, and a status badge
Card::product(
    imageField: 'image',
    titleField: 'name',
    priceField: 'price',
    descriptionField: 'description',
    badgeField: 'status',
);

// Title and description, no image
Card::simple(titleField: 'name', descriptionField: 'description');

// Background image with overlay text (16/9)
Card::media(imageField: 'cover', titleField: 'title', descriptionField: 'excerpt');
```

## Custom cards

```php
Card::make()
    ->imageField('photo')
    ->title('name')
    ->subtitle('role')
    ->badge('status', fn ($state) => $state === 'active' ? 'success' : 'secondary')
    ->imagePosition('left')      // top, left, right, background
    ->aspectRatio('1/1')
    ->padding('lg')              // sm, md, lg, xl
    ->gap('md')                  // sm, md, lg
    ->actionsPosition('bottom'); // top-right (default), top-left, bottom, bottom-center, bottom-left, bottom-right
```

## API reference

| Method | Description |
|--------|-------------|
| `product()`, `simple()`, `media()` | Presets |
| `imageField()`, `titleField()` / `title()`, `subtitle()`, `descriptionField()`, `priceField()` | Record fields to display |
| `badge($field, $colorCallback)` / `badgeField()` | Badge field and color |
| `metadata(array)` | Extra fields |
| `showImage()`, `imagePosition()`, `aspectRatio()` | Image layout |
| `padding()`, `gap()`, `hoverable()`, `style()` | Appearance |
| `actionsPosition()` | Where row actions appear |
| `schema()`, `columns()`, `header()`, `footer()` | Advanced content |
