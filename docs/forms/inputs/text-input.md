---
title: TextInput
description: Single-line text input with types, affixes, masks and a character counter.
order: 1
---

# TextInput

A single-line text input. It supports the text, email, password, tel, url and search types.

## Basic usage

```php
use Laravilt\Forms\Components\TextInput;

TextInput::make('name')
    ->label('Full Name')
    ->required();
```

## Input types

```php
TextInput::make('email')->email();
TextInput::make('password')->password()->revealable();
TextInput::make('phone')->tel();
TextInput::make('website')->url();
TextInput::make('search')->search();
TextInput::make('color')->type('color');
```

`email()` and `url()` also add the matching validation rule.

## Prefix and suffix

```php
TextInput::make('price')
    ->prefix('$')
    ->suffix('USD');

TextInput::make('email')
    ->prefixIcon('Mail')
    ->suffixIcon('Check');
```

Icons are [Lucide](https://lucide.dev/icons) icon names.

## Length and counter

```php
TextInput::make('username')
    ->minLength(3)
    ->maxLength(20)
    ->characterCount();
```

## Masks and patterns

```php
TextInput::make('phone')->mask('(999) 999-9999');

TextInput::make('code')->pattern('[A-Z]{3}');
```

## API reference

| Method | Description |
|--------|-------------|
| `type(string)` | Set the HTML input type |
| `email()` / `password()` / `tel()` / `url()` / `search()` | Type shortcuts |
| `revealable(bool)` | Show or hide toggle for passwords |
| `prefix(string)` / `suffix(string)` | Text affixes |
| `prefixIcon(string)` / `suffixIcon(string)` | Icon affixes |
| `minLength(int)` / `maxLength(int)` | Length limits (also validated) |
| `characterCount(bool)` | Show a character counter |
| `mask(string)` | Input mask |
| `pattern(string)` | HTML pattern attribute |
| `step(int\|float)` | Step for numeric types |

## Related

- [Textarea](textarea.md)
- [NumberField](number-field.md)
