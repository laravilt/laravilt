---
title: Styling
description: Customize action colors, icons, variants, sizes, and tooltips.
order: 1
---

# Styling

## Label and color

```php
use Laravilt\Actions\Action;

Action::make('approve')
    ->label('Approve')
    ->color('success'); // e.g. primary, secondary, success, warning, destructive, gray
```

## Icons

Icons use [Lucide](https://lucide.dev/icons) names in PascalCase:

```php
Action::make('send')
    ->icon('Send')
    ->iconPosition('after'); // 'before' (default) or 'after'
```

## Variants

```php
Action::make('view')->button();                      // button (default)
Action::make('delete')->icon('Trash2')->iconButton(); // icon only
Action::make('details')->link();                      // text link
Action::make('cancel')->outlined();                   // outlined button
```

## Size, tooltip, and disabled

```php
Action::make('archive')
    ->size('sm')
    ->tooltip('Archive this record')
    ->disabled(! auth()->user()->isAdmin());
```

`disabled()` takes a boolean. To hide an action based on the record, use [`visible()` / `hidden()`](authorization.md#visibility).

## Extra attributes

```php
Action::make('export')->extraAttributes(['data-testid' => 'export-button']);
```

## API reference

| Method | Description |
|--------|-------------|
| `label()` | Button text |
| `color()` | Button color |
| `icon($icon, $position = null)`, `iconPosition()` | Icon and position |
| `button()`, `iconButton()`, `link()` | Variant |
| `outlined()` | Outlined style |
| `size()` | Button size |
| `tooltip()` | Hover text |
| `disabled(bool)` | Disable the button |
| `extraAttributes()` | Extra HTML attributes |
