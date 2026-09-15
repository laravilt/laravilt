---
title: Tables
description: Build searchable, sortable, filterable data tables for your resources with a fluent PHP API.
order: 4
---

# Tables

The `laravilt/tables` package turns a fluent PHP definition into a fully interactive data table rendered by Inertia v3. It renders with Vue 3 (shadcn-vue / reka-ui) or React 19 (shadcn/ui), styled with Tailwind CSS v4. You describe columns, filters, and actions in PHP; Laravilt handles querying, pagination, search, sorting, and the frontend.

> React support requires Laravilt v1.1 or later.

```php
use Laravilt\Actions\DeleteAction;
use Laravilt\Actions\DeleteBulkAction;
use Laravilt\Actions\EditAction;
use Laravilt\Tables\Columns\ImageColumn;
use Laravilt\Tables\Columns\TextColumn;
use Laravilt\Tables\Filters\TrashedFilter;
use Laravilt\Tables\Table;

public static function table(Table $table): Table
{
    return $table
        ->columns([
            ImageColumn::make('avatar')->circular(),
            TextColumn::make('name')->searchable()->sortable(),
            TextColumn::make('email')->copyable(),
        ])
        ->filters([
            TrashedFilter::make(),
        ])
        ->recordActions([
            EditAction::make(),
            DeleteAction::make(),
        ])
        ->bulkActions([
            DeleteBulkAction::make(),
        ])
        ->defaultSort('created_at', 'desc');
}
```

Tables are usually defined in a resource's `table()` method (see [Your First Resource](../getting-started/first-resource.md)). You can also generate a standalone table class in `app/Tables` with `php artisan make:table UsersTable [--actions]`.

## In this section

1. [Columns](columns/README.md): text, image, icon, color, and editable columns
2. [Filters](filters/README.md): select, ternary, trashed, and custom filters
3. [Actions](actions/README.md): row, bulk, and header actions in tables
4. [Features](features/README.md): search, sorting, column visibility, grouping, reordering, fixed actions, and polling
5. [Display](display/README.md): pagination, grid view, and cards
6. [API](api/README.md): expose a resource as a REST API
7. [Customization](custom/README.md): reusable columns and frontend components

Try it live at [demo.laravilt.com](https://demo.laravilt.com) (login `admin@laravilt.com` / `password`).
