---
title: Reactive Fields
description: Live updates, dependent options and conditional visibility with $get and $set.
order: 8
---

# Reactive Fields

Reactive fields send their value to the server when it changes. The server can then update other fields, reload options, or show and hide fields.

## Live updates

```php
use Illuminate\Support\Str;
use Laravilt\Forms\Components\TextInput;

TextInput::make('name')
    ->live()
    ->afterStateUpdated(function ($state, $set) {
        $set('slug', Str::slug($state));
    });

TextInput::make('slug');
```

`live(debounce: 500)` waits for the user to stop typing, and `lazy()` updates on blur.

## Dependent options

```php
use Laravilt\Forms\Components\Select;
use Laravilt\Support\Utilities\Get;

Select::make('country')
    ->options(['US' => 'USA', 'CA' => 'Canada'])
    ->live();

Select::make('state')
    ->options(fn (Get $get) => match ($get('country')) {
        'US' => ['CA' => 'California', 'NY' => 'New York'],
        'CA' => ['ON' => 'Ontario', 'BC' => 'British Columbia'],
        default => [],
    })
    ->dependsOn('country');
```

## Conditional visibility

```php
use Laravilt\Forms\Components\Toggle;

Toggle::make('has_discount')->live();

TextInput::make('discount_code')
    ->visible(fn (Get $get) => (bool) $get('has_discount'));
```

## Setting other fields

```php
use Laravilt\Support\Utilities\Set;

Select::make('template')
    ->options(['blank' => 'Blank', 'blog' => 'Blog'])
    ->live()
    ->afterStateUpdated(function ($state, Set $set) {
        if ($state === 'blog') {
            $set('layout', 'sidebar');
        }
    });
```

## Injected closure parameters

Closures receive parameters by type or by name:

| Parameter | Value |
|-----------|-------|
| `Get $get` | Read another field's value |
| `Set $set` | Update another field's value |
| `$state` | The current field's value |
| `$record` | The current Eloquent record (when editing) |
| `$operation` | The current operation, e.g. `create` or `edit` |
| `$data` | All form data |

## Related

- [Select](../selection/select.md)
- [Validation](../validation/README.md)
