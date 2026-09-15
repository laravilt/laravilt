---
title: KeyValueEntry
description: Key-value pairs displayed as a table.
order: 7
---

# KeyValueEntry

Displays an associative array as a two-column table.

```php
use Laravilt\Infolists\Entries\KeyValueEntry;

KeyValueEntry::make('settings')
    ->keyLabel('Setting')
    ->valueLabel('Value')
    ->copyableKeys()
    ->copyableValues();
```

## API reference

| Method | Description |
|--------|-------------|
| `keyLabel(string)` / `valueLabel(string)` | Column headers |
| `copyableKeys(bool)` / `copyableValues(bool)` | Copy buttons |
