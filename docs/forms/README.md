---
title: Forms
description: Build forms in PHP with 29 field types, rendered by Vue or React.
order: 3
---

# Forms

The `laravilt/forms` package lets you describe forms in PHP with a fluent API. Laravilt serializes the schema through Inertia v3 and renders it with Vue 3 (shadcn-vue / reka-ui) or React 19 (shadcn/ui), styled with Tailwind CSS v4.

> React support requires Laravilt v1.1 or later.

## Basic usage

In a resource, the form is defined in the static `form()` method:

```php
use Laravilt\Forms\Components\Select;
use Laravilt\Forms\Components\TextInput;
use Laravilt\Schemas\Components\Section;
use Laravilt\Schemas\Schema;

public static function form(Schema $schema): Schema
{
    return $schema->schema([
        Section::make('User Information')
            ->columns(2)
            ->schema([
                TextInput::make('name')->required()->maxLength(255),
                TextInput::make('email')->email()->required(),
                Select::make('role')->options([
                    'admin' => 'Administrator',
                    'user' => 'User',
                ]),
            ]),
    ]);
}
```

To generate a standalone form class, run `php artisan make:form UserForm` (add `--resource` for a CRUD-style form).

## Sections

1. [Inputs](inputs/README.md): text, textarea, number, PIN and hidden fields
2. [Selection](selection/README.md): select, radio, checkbox, toggle
3. [Date & Time](datetime/README.md): date, date-time, time and date-range pickers
4. [Pickers](pickers/README.md): color, icon, tags, slider, rating
5. [Media](media/README.md): file upload, rich text, markdown and code editors
6. [Data](data/README.md): repeater, builder, key-value
7. [Layouts](layouts/README.md): sections, grids, tabs and wizards inside forms
8. [Reactive Fields](reactive/README.md): live updates and dependent fields
9. [Validation](validation/README.md): rules and messages
10. [Custom Fields](custom/README.md): build your own field types

## Related

- [Schemas](../schemas/README.md): the layout components used by forms
- [Infolists](../infolists/README.md): read-only display of records
