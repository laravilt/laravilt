---
title: Inputs
description: Text-based input fields and the methods every field shares.
order: 1
---

# Inputs

Text-based fields for collecting user data.

| Component | Description |
|-----------|-------------|
| [TextInput](text-input.md) | Single-line text (email, password, tel, url, search) |
| [Textarea](textarea.md) | Multi-line text with optional autosize |
| [NumberField](number-field.md) | Numeric input with increment and decrement buttons |
| [PinInput](pin-input.md) | PIN / OTP code entry |
| [Hidden](hidden.md) | Hidden value |

## Common methods

Every field extends `Laravilt\Forms\Components\Field` and shares these methods:

```php
use Laravilt\Forms\Components\TextInput;

TextInput::make('name')
    ->label('Full Name')
    ->placeholder('Enter name...')
    ->helperText('Your legal name')
    ->hint('As shown on ID')
    ->required()
    ->disabled()
    ->readonly()
    ->default('John')
    ->autofocus()
    ->autocomplete('name')
    ->columnSpan(2);
```

Visibility is controlled with `hidden()` and `visible()`, both of which accept a closure. See [Reactive Fields](../reactive/README.md).
