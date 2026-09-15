---
title: Component
description: The abstract base class for Laravilt UI components.
order: 1
---

# Component

`Laravilt\Support\Component` is the abstract base class for Laravilt UI components. It uses every trait in [Concerns](concerns/README.md) and implements `Arrayable`, `Jsonable`, `Buildable` and `Serializable`.

## Creating a component

Generate a component class and its Blade view:

```bash
php artisan laravilt:component RatingInput
```

This creates `app/Components/RatingInput.php` and `resources/views/components/rating-input.blade.php`. Add `--force` to overwrite existing files.

```php
<?php

namespace App\Components;

use Laravilt\Support\Component;

class RatingInput extends Component
{
    protected string $view = 'components.rating-input';

    protected function setUp(): void
    {
        $this->placeholder('Rate from 1 to 5');
    }
}

// Usage
RatingInput::make('rating')
    ->label('Your rating')
    ->required();
```

`make(string $name)` resolves the class from the container, sets the name and calls `setUp()`.

## Methods

| Method | Returns | Description |
|--------|---------|-------------|
| `make(string $name)` | `static` | Create an instance (static) |
| `getName()` | `string` | Component name |
| `meta(array $meta)` | `static` | Merge extra metadata |
| `getMeta()` | `array` | Metadata |
| `render()` | `string` | Render `$view` to HTML (empty when hidden) |
| `toLaraviltProps()` | `array` | Props for the Inertia frontend |
| `toApiProps()` | `array` | Props for REST APIs |
| `toFlutterProps()` | `array` | Props for Flutter clients |
| `toArray()` / `toJson()` | `array` / `string` | Serialize |

## Serialized props

`toLaraviltProps()` returns:

```php
[
    'component' => 'rating_input',   // snake_case class name
    'id' => 'rating',
    'name' => 'rating',
    'state' => null,
    'label' => 'Your rating',
    'placeholder' => 'Rate from 1 to 5',
    'helperText' => null,
    'hidden' => false,
    'disabled' => false,
    'readonly' => false,
    'required' => true,
    'columnSpan' => null,
    'columnStart' => null,
    'rtl' => false,
    'theme' => 'light',
    'locale' => 'en',
    'meta' => [],
]
```

## Related

- [Concerns](concerns/README.md)
- [Forms](../forms/README.md)
