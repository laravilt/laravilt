---
title: Forms FAQ
description: Questions about form fields, validation and reactive fields.
order: 2
---

# Forms FAQ

## How do I define a resource form?

Resource forms are a `Schema`. The generator creates a `{Model}Form` class:

```php
<?php

use Laravilt\Forms\Components\TextInput;
use Laravilt\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $form): Schema
    {
        return $form->schema([
            TextInput::make('name')->required(),
            TextInput::make('email')->email()->required(),
        ]);
    }
}
```

## How do I add validation rules?

```php
use Laravilt\Forms\Components\TextInput;

TextInput::make('email')
    ->email()
    ->required()
    ->unique('users', 'email', ignoreRecord: true)
    ->rules(['max:255']);
```

`->rules()` accepts a string, an array, or a closure that returns rules. Any Laravel rule works, including rule objects. See [Validation](../forms/validation/README.md).

## How do I create dependent fields?

Mark the parent `->live()` and read its value with `Get`:

```php
use Laravilt\Forms\Components\Select;
use Laravilt\Support\Utilities\Get;

Select::make('country_id')
    ->options(Country::pluck('name', 'id'))
    ->live();

Select::make('state_id')
    ->options(fn (Get $get) => State::where('country_id', $get('country_id'))->pluck('name', 'id'));
```

See [Reactive Fields](../forms/reactive/README.md).

## How do I show or hide a field conditionally?

```php
use Laravilt\Forms\Components\TextInput;
use Laravilt\Forms\Components\Toggle;
use Laravilt\Support\Utilities\Get;

Toggle::make('has_website')->live();

TextInput::make('website_url')
    ->visible(fn (Get $get) => $get('has_website'));
```

## How do I handle file uploads?

```php
use Laravilt\Forms\Components\FileUpload;

FileUpload::make('avatar')
    ->image()
    ->disk('public')
    ->directory('avatars');
```

See [Media Fields](../forms/media/README.md).

## Can I build my own field type?

Yes: `php artisan make:form-component ColorSwatch --vue` (or `--react`) scaffolds the PHP field class and its frontend component.

## Related

- [Forms Documentation](../forms/README.md)
- [Schemas FAQ](schemas.md)
