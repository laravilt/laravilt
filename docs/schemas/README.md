---
title: Schemas
description: The Schema container and layout components shared by forms and infolists.
order: 6
---

# Schemas

The `laravilt/schemas` package provides the `Schema` container and the layout components (Section, Grid, Tabs, Wizard, Split, Fieldset) used by [forms](../forms/README.md) and [infolists](../infolists/README.md). It ships Vue and React renderers.

> React support requires Laravilt v1.1 or later.

## Quick example

```php
use Laravilt\Forms\Components\TextInput;
use Laravilt\Schemas\Components\Section;
use Laravilt\Schemas\Schema;

Schema::make()
    ->columns(2)
    ->schema([
        Section::make('User Information')
            ->icon('User')
            ->schema([
                TextInput::make('name'),
                TextInput::make('email'),
            ]),
    ]);
```

In a resource you don't create the schema yourself. `form(Schema $schema)` and `infolist(Schema $schema)` receive one.

## Generators

```bash
php artisan make:schema UserDetails              # app/Schemas/UserDetails.php
php artisan make:schema Callout --component      # app/Schemas/Components/Callout.php
```

## Pages

1. [Schema Class](schema.md): the container, its methods and validation helpers
2. [Layout Components](components/README.md): Section, Grid, Tabs, Wizard, Split, Fieldset
