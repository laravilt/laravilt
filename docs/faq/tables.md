---
title: Tables FAQ
description: Questions about table columns, filters and actions.
order: 3
---

# Tables FAQ

## How do I define a resource table?

The generator creates a `{Model}Table` class:

```php
<?php

use Laravilt\Tables\Columns\TextColumn;
use Laravilt\Tables\Table;

class UserTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->searchable()->sortable(),
            TextColumn::make('email')->searchable(),
            TextColumn::make('created_at')->dateTime('M j, Y')->sortable(),
        ]);
    }
}
```

## How do I format values?

```php
TextColumn::make('price')->money('USD');
TextColumn::make('created_at')->dateTime('M j, Y');
```

See [Columns](../tables/columns/README.md).

## How do I add filters?

```php
use Laravilt\Tables\Filters\SelectFilter;
use Laravilt\Tables\Filters\TernaryFilter;
use Laravilt\Tables\Filters\TrashedFilter;

$table->filters([
    SelectFilter::make('status')->options([
        'active' => 'Active',
        'inactive' => 'Inactive',
    ]),
    TernaryFilter::make('is_verified'),
    TrashedFilter::make(),
]);
```

## How do I filter by date?

There is no dedicated date filter class. Use a `Filter` with a form and a query:

```php
use Laravilt\Forms\Components\DatePicker;
use Laravilt\Tables\Filters\Filter;

Filter::make('created_from')
    ->form([DatePicker::make('created_from')])
    ->query(fn ($query, $value) => $query->whereDate('created_at', '>=', $value));
```

See [Filters](../tables/filters/README.md).

## How do I add row and bulk actions?

Actions live in the `laravilt/actions` package (namespace `Laravilt\Actions`):

```php
use Laravilt\Actions\DeleteAction;
use Laravilt\Actions\DeleteBulkAction;
use Laravilt\Actions\EditAction;

$table
    ->recordActions([
        EditAction::make(),
        DeleteAction::make(),
    ])
    ->bulkActions([
        DeleteBulkAction::make(),
    ]);
```

`->actions()` also works for row actions. `->headerActions()` and `->toolbarActions()` place actions above the table.

## How do I ask for confirmation?

```php
use Laravilt\Actions\Action;

Action::make('archive')
    ->requiresConfirmation()
    ->modalHeading('Archive record')
    ->action(fn ($record) => $record->archive());
```

See [Table Actions](../tables/actions/README.md) and [Actions](../actions/README.md).

## Related

- [Tables Documentation](../tables/README.md)
