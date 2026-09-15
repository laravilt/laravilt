---
title: PinInput
description: PIN and one-time-code input with one box per character.
order: 4
---

# PinInput

A PIN or one-time-code input that renders one box per character.

## Basic usage

```php
use Laravilt\Forms\Components\PinInput;

PinInput::make('otp')
    ->label('Verification Code')
    ->length(6);
```

## Masked PIN

```php
PinInput::make('pin')
    ->length(4)
    ->mask();
```

## OTP mode and input type

```php
PinInput::make('verification_code')
    ->length(6)
    ->otp()
    ->type('numeric'); // numeric, alpha or alphanumeric
```

## API reference

| Method | Description |
|--------|-------------|
| `length(int)` | Number of characters |
| `mask(bool)` | Hide entered characters |
| `otp(bool)` | Enable one-time-code autocomplete |
| `type(string)` | `numeric`, `alpha` or `alphanumeric` |
| `align(string)` | `left`, `center` or `right` |
