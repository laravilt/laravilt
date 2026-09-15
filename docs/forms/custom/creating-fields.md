---
title: Creating Fields
description: Write the PHP class for a custom form field.
order: 1
---

# Creating Fields

## Generate the class

```bash
php artisan make:form-component EmojiPicker
```

This creates `app/Forms/Components/EmojiPicker.php`, which extends `Laravilt\Forms\Components\Field`.

## Add options

Store each option in a property and expose it in `toLaraviltProps()`. Closures are resolved with `$this->evaluate()`:

```php
<?php

namespace App\Forms\Components;

use Closure;
use Laravilt\Forms\Components\Field;

class EmojiPicker extends Field
{
    protected string $view = 'forms.components.emoji-picker';

    protected array|Closure $emojis = ['😀', '🎉', '👍', '❤️'];

    public function emojis(array|Closure $emojis): static
    {
        $this->emojis = $emojis;

        return $this;
    }

    public function toLaraviltProps(): array
    {
        return array_merge(parent::toLaraviltProps(), [
            'emojis' => $this->evaluate($this->emojis),
        ]);
    }
}
```

Avoid method names that `Field` already defines with a different signature, such as `max()`, `min()`, `color()` or `options()`. PHP rejects incompatible overrides.

## Component name

The props include a `component` key: the snake_case class name (`emoji_picker`). The frontend resolves it to the component registered as `laravilt-emoji-picker`. See [Frontend Components](frontend-components.md).

## Use it

```php
use App\Forms\Components\EmojiPicker;

EmojiPicker::make('reaction')
    ->label('Reaction')
    ->emojis(['👍', '👎'])
    ->required();
```

Custom fields get every shared field feature: validation, `live()`, `default()`, `visible()` and so on.

## Extend an existing field

To preconfigure a built-in field, extend it and override `setUp()`. It keeps the parent's frontend component:

```php
<?php

namespace App\Forms\Components;

use Laravilt\Forms\Components\TextInput;

class PhoneInput extends TextInput
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->tel()
            ->mask('(999) 999-9999')
            ->placeholder('(555) 123-4567');
    }
}
```
