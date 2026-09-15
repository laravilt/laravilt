---
title: RateInput
description: Star rating input with half ratings and custom icons.
order: 5
---

# RateInput

A star rating input.

```php
use Laravilt\Forms\Components\RateInput;

RateInput::make('rating')
    ->maxRating(5)
    ->allowHalf()
    ->icon('Star')
    ->color('warning')
    ->showValue();
```

## API reference

| Method | Description |
|--------|-------------|
| `maxRating(int)` | Number of icons |
| `allowHalf(bool)` | Allow half steps |
| `icon(string)` | Lucide icon name |
| `color(string)` | Fill color |
| `showValue(bool)` | Show the numeric value |
