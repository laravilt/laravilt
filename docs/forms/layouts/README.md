---
title: Layouts
description: Arrange form fields with sections, grids, tabs and wizards from the schemas package.
order: 7
---

# Layouts

Forms use the layout components from `laravilt/schemas`. Nest fields inside them with `schema()`:

```php
use Laravilt\Forms\Components\TextInput;
use Laravilt\Schemas\Components\Grid;
use Laravilt\Schemas\Components\Section;
use Laravilt\Schemas\Components\Tab;
use Laravilt\Schemas\Components\Tabs;

Section::make('Contact Information')
    ->description('How to reach the user')
    ->icon('Phone')
    ->collapsible()
    ->columns(2)
    ->schema([
        TextInput::make('phone'),
        TextInput::make('address'),
    ]);

Grid::make(['default' => 1, 'lg' => 3])
    ->schema([/* ... */]);

Tabs::make('settings')
    ->tabs([
        Tab::make('Basic')->icon('User')->schema([/* ... */]),
        Tab::make('Advanced')->schema([/* ... */]),
    ]);
```

Any field can span columns with `columnSpan(2)` or `columnSpanFull()`.

## Components

- [Section](../../schemas/components/section.md): grouped fields with a heading
- [Grid](../../schemas/components/grid.md): responsive columns
- [Tabs](../../schemas/components/tabs.md): tabbed panels
- [Wizard](../../schemas/components/wizard.md): multi-step forms
- [Split](../../schemas/components/split.md): main and sidebar panes
- [Fieldset](../../schemas/components/fieldset.md): labelled group
