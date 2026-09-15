---
title: KeyValue
description: Editable list of key-value pairs.
order: 3
---

# KeyValue

An editable list of key-value pairs, stored as an associative array.

```php
use Laravilt\Forms\Components\KeyValue;

KeyValue::make('metadata')
    ->keyLabel('Attribute')
    ->valueLabel('Value')
    ->addActionLabel('Add attribute')
    ->reorderable()
    ->default([
        'debug' => 'false',
        'cache' => 'true',
    ]);
```

## API reference

| Method | Description |
|--------|-------------|
| `keyLabel(string)` / `valueLabel(string)` | Column labels |
| `addActionLabel(string)` | Add button label (alias: `addButtonLabel()`) |
| `reorderable(bool)` | Drag to reorder |
| `deletable(bool)` | Allow removing rows |
