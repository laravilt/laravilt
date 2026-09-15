---
title: Slider
description: Numeric range slider with steps, marks and a value label.
order: 4
---

# Slider

A range slider for numeric values.

```php
use Laravilt\Forms\Components\Slider;

Slider::make('price')
    ->min(0)
    ->max(1000)
    ->step(10)
    ->showValue();

Slider::make('rating')
    ->min(1)
    ->max(5)
    ->marks([1 => 'Poor', 3 => 'Average', 5 => 'Excellent']);
```

## API reference

| Method | Description |
|--------|-------------|
| `min(int\|float)` / `max(int\|float)` | Range |
| `step(int\|float)` | Increment |
| `marks(array)` | Labelled tick marks |
| `showValue(bool)` | Show the current value |
