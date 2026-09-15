---
title: Fieldset
description: Group components under a legend.
order: 6
---

# Fieldset

Groups components under a legend.

```php
use Laravilt\Forms\Components\TextInput;
use Laravilt\Schemas\Components\Fieldset;

Fieldset::make('billing')
    ->legend('Billing Information')
    ->schema([
        TextInput::make('card_number'),
        TextInput::make('expiry'),
    ]);
```

The name doesn't become the label. Set it with `label()` or `legend()`, which also sets the label.

> Fieldset has no dedicated frontend component yet, and the panel's schema renderer does not map it. Use [Section](section.md) for grouped content in resource forms.

## API reference

| Method | Description |
|--------|-------------|
| `make(string)` | Create (name required) |
| `label(string\|Closure)` | Label |
| `legend(string\|Closure)` | Legend (also sets the label) |
| `schema(array)` | Child components |
