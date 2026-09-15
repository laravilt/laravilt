---
title: Validation
description: Laravel validation rules, helpers and custom messages for form fields.
order: 9
---

# Validation

Fields collect Laravel validation rules. The schema validates them when the form is submitted.

## Rule helpers

```php
use Laravilt\Forms\Components\TextInput;

TextInput::make('email')
    ->required()
    ->email()
    ->unique('users', 'email', ignoreRecord: true)
    ->maxLength(255);

TextInput::make('age')
    ->numeric()
    ->integer()
    ->minValue(18)
    ->maxValue(120);

TextInput::make('password')
    ->password()
    ->minLength(8)
    ->confirmed();
```

## Custom rules

```php
TextInput::make('username')
    ->rules([
        'required',
        'alpha_dash',
        function ($attribute, $value, $fail) {
            if (in_array(strtolower($value), ['admin', 'root'])) {
                $fail('This username is reserved.');
            }
        },
    ]);

TextInput::make('code')->rule('size:6');
```

## Messages and attribute names

```php
TextInput::make('email')
    ->required()
    ->email()
    ->validationMessages([
        'required' => 'Please enter your email.',
        'email' => 'Please enter a valid email.',
    ])
    ->validationAttribute('email address');
```

## Available helpers

| Method | Rule |
|--------|------|
| `required()` | `required` |
| `email()` / `url()` | `email` / `url` |
| `numeric()` / `integer()` | `numeric` / `integer` |
| `minLength(int)` / `maxLength(int)` | `min` / `max` (strings) |
| `minValue()` / `maxValue()` (or `min()` / `max()`) | `min` / `max` (numbers) |
| `unique(table, column, ignoreId, ignoreRecord)` | `unique` |
| `exists(table, column)` | `exists` |
| `confirmed()` / `same(field)` | `confirmed` / `same` |
| `regex(pattern)` | `regex` |
| `alpha()` / `alphaDash()` / `alphaNum()` | `alpha`, `alpha_dash`, `alpha_num` |
| `rules(array\|string\|Closure)` / `rule(mixed)` | Any Laravel rule |

## Related

- [Reactive Fields](../reactive/README.md)
- [TextInput](../inputs/text-input.md)
