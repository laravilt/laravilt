---
title: Tabs
description: Organize components into tabbed panels.
order: 3
---

# Tabs

Organizes components into tabbed panels.

## Basic usage

```php
use Laravilt\Forms\Components\TextInput;
use Laravilt\Schemas\Components\Tab;
use Laravilt\Schemas\Components\Tabs;

Tabs::make('settings')
    ->tabs([
        Tab::make('General')
            ->schema([
                TextInput::make('name'),
            ]),
        Tab::make('Security')
            ->icon('Shield')
            ->badge('2')
            ->schema([
                TextInput::make('password')->password(),
            ]),
    ]);
```

A tab's label defaults to its name. Override it with `label()`.

## Active tab and URL persistence

```php
Tabs::make('settings')
    ->activeTab(1)                 // second tab (0-indexed)
    ->persistTabInQueryString()
    ->tabs([/* ... */]);
```

## API reference

**Tabs**

| Method | Description |
|--------|-------------|
| `make(string)` | Create (name required) |
| `tabs(array)` | `Tab` instances |
| `activeTab(int)` | Initially active tab |
| `persistTabInQueryString(bool)` | Keep the active tab in the URL |

**Tab**

| Method | Description |
|--------|-------------|
| `make(string)` | Create; the name becomes the label |
| `label(string\|Closure)` | Tab label |
| `icon(string\|Closure)` | Lucide icon |
| `badge(string\|Closure)` | Badge text |
| `schema(array)` | Tab content |

`Laravilt\Schemas\Components\Tabs\Tab` is an alias of `Tab`.
