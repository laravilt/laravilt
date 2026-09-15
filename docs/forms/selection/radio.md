---
title: Radio
description: Radio button group for choosing a single option.
order: 2
---

# Radio

A radio button group for choosing exactly one option.

## Basic usage

```php
use Laravilt\Forms\Components\Radio;

Radio::make('payment_method')
    ->options([
        'card' => 'Credit Card',
        'paypal' => 'PayPal',
        'bank' => 'Bank Transfer',
    ]);
```

## Descriptions

```php
Radio::make('plan')
    ->options(['basic' => 'Basic', 'pro' => 'Professional'])
    ->descriptions([
        'basic' => '$9/month',
        'pro' => '$29/month',
    ]);
```

## Inline and boolean

```php
Radio::make('size')
    ->options(['s' => 'Small', 'm' => 'Medium', 'l' => 'Large'])
    ->inline();

Radio::make('newsletter')->boolean();
```

## API reference

| Method | Description |
|--------|-------------|
| `options(array\|Closure)` | Set options |
| `descriptions(array)` | Description per option |
| `inline(bool)` | Display options on one line |
| `boolean(bool)` | Yes/No options |
