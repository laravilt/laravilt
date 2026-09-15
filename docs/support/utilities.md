---
title: Utilities
description: Get and Set state helpers, RTL detection, colors and frontend stack detection.
order: 3
---

# Utilities

## Get

`Laravilt\Support\Utilities\Get` reads nested values with dot notation:

```php
use Laravilt\Support\Utilities\Get;

$data = ['user' => ['name' => 'John']];
$get = new Get($data);

$get('user.name');          // 'John'
$get('user.email', '');     // default value

Get::value($data, 'user.name', 'default');  // static helper
```

It is injected into component closures:

```php
TextInput::make('state')
    ->visible(fn (Get $get) => $get('country') === 'US');
```

## Set

`Laravilt\Support\Utilities\Set` writes nested values by reference and tracks changes:

```php
use Laravilt\Support\Utilities\Set;

$data = [];
$set = new Set($data);

$set('user.name', 'John');
$set('user.address.city', 'NYC');

$set->hasChanges();  // true
$set->getData();     // the updated array

Set::value($data, 'user.name', 'Jane');  // static helper, returns the array
```

In closures:

```php
TextInput::make('full_name')
    ->afterStateUpdated(fn (Set $set, $state) => $set('display_name', strtoupper($state)));
```

## Translator

`Laravilt\Support\Utilities\Translator` detects right-to-left locales:

```php
use Laravilt\Support\Utilities\Translator;

Translator::isRTL('ar');         // true
Translator::isRTL();             // checks the current locale
Translator::direction('he');     // 'rtl'
Translator::getRTLLocales();     // ['ar', 'he', 'fa', 'ur', 'yi', 'ji', 'iw']
Translator::addRTLLocale('ku');  // register another RTL locale
```

## Color

`Laravilt\Support\Colors\Color` holds the default hex colors as constants (`Color::Primary`, `Color::Secondary`, `Color::Success`, `Color::Danger`, `Color::Warning`, `Color::Info`, plus a palette). `Color::all()` and `Color::semantic()` return them as arrays.

## Frontend

`Laravilt\Support\Frontend` tells packages and your code which frontend stack the app uses:

| Method | Returns |
|--------|---------|
| `Frontend::stack()` | `'vue'` or `'react'`: the `laravilt-support.frontend` config value, otherwise `detect()` |
| `Frontend::detect(?string $packageJsonPath = null)` | `'react'` if `package.json` has React but not Vue, otherwise `'vue'` |
| `Frontend::isReact()` / `Frontend::isVue()` | `bool` |
| `Frontend::isValid(string $stack)` | `bool` |
| `Frontend::resourceDirectory(?string $stack = null)` | `'react'` for React, `'js'` for Vue (the folder under a package's `resources/`) |

Set the stack explicitly in `.env` (the installer writes this for you):

```env
LARAVILT_FRONTEND=react
```

This is the `frontend` key in `config/laravilt-support.php`.

> React support requires Laravilt v1.1 or later.

## Related

- [Component](component.md)
- [Concerns](concerns/README.md)
