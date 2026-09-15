---
title: CheckboxColumn
description: Configure a checkbox for a boolean table column.
order: 8
---

# CheckboxColumn

```php
use Laravilt\Tables\Columns\CheckboxColumn;

CheckboxColumn::make('agreed_to_terms')
    ->label('Terms')
    ->rules(['boolean']);
```

> The bundled Vue and React tables have no dedicated renderer for `CheckboxColumn`. It displays with the text renderer, and the panel runs update hooks only for `ToggleColumn`. For an inline boolean switch that saves automatically, use [ToggleColumn](toggle-column.md).

## API reference

| Method | Description |
|--------|-------------|
| `beforeStateUpdated()` | Before-update hook |
| `afterStateUpdated()` | After-update hook |
| `rules()` | Validation rules |
