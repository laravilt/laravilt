---
title: Grid View
description: Display table records as a responsive grid of cards.
order: 2
---

# Grid View

Give the table a [card](cards.md) configuration and users can switch between table and grid view.

```php
use Laravilt\Tables\Card;

$table
    ->columns([...])
    ->card(
        Card::product(
            imageField: 'thumbnail',
            titleField: 'name',
            priceField: 'price',
            descriptionField: 'description',
        )
    )
    ->cardsPerRow(4);
```

## Grid only

Hide the table view:

```php
$table
    ->card(Card::simple(titleField: 'name', descriptionField: 'excerpt'))
    ->gridOnly();
```

## API reference

| Method | Description |
|--------|-------------|
| `card(Card $card)` | Enable grid view with this card |
| `cardsPerRow(int)` | Cards per row (default 3) |
| `gridOnly()` | Show only the grid |
