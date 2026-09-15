---
title: NumberField
description: Numeric input with increment and decrement controls, currency and percentage formats.
order: 3
---

# NumberField

A numeric input with increment and decrement buttons.

## Basic usage

```php
use Laravilt\Forms\Components\NumberField;

NumberField::make('quantity')
    ->label('Quantity');
```

## Range and step

```php
NumberField::make('age')
    ->minValue(0)
    ->maxValue(120);

NumberField::make('price')
    ->step(0.01)
    ->prefix('$');
```

## Formatting

```php
NumberField::make('amount')->currency('EUR');

NumberField::make('discount')->percentage();

NumberField::make('total')
    ->locale('de-DE')
    ->formatOptions(['minimumFractionDigits' => 2]);
```

`formatOptions()` accepts `Intl.NumberFormat` options.

## API reference

| Method | Description |
|--------|-------------|
| `min()` / `minValue()` | Minimum value |
| `max()` / `maxValue()` | Maximum value |
| `step(int\|float)` | Increment step |
| `prefix(string)` / `suffix(string)` | Text affixes |
| `currency(string)` | Currency format (default `USD`) |
| `percentage()` | Percentage format |
| `locale(string)` | Number locale |
| `formatOptions(array)` | Custom `Intl.NumberFormat` options |
