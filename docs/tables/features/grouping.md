---
title: Grouping
description: Group table rows by a column value.
order: 4
---

# Grouping

Define the available groups with `Laravilt\Tables\Grouping\Group`. Users pick one from the table toolbar.

```php
use Laravilt\Tables\Grouping\Group;

$table
    ->groups([
        Group::make('status')->label('Status'),
        Group::make('category.name')->label('Category'),
    ])
    ->defaultGroup('status');
```

## Group titles and descriptions

```php
Group::make('department_id')
    ->label('Department')
    ->getTitleFromRecordUsing(fn ($record, $value) => $record->department->name)
    ->getDescriptionFromRecordUsing(fn ($record, $value) => $record->department->location)
    ->collapsible();
```

Or read them from attributes:

```php
Group::make('author_id')
    ->titleAttribute('author_name')
    ->descriptionAttribute('author_email');
```

## Pagination while grouped

Infinite scroll is disabled while a group is active. You can set a separate page size:

```php
$table->groupedPerPage(100); // null = default, -1 = no pagination while grouped
```

## API reference

| Method | Description |
|--------|-------------|
| `Table::groups()` | Available groups |
| `Table::defaultGroup()` | Group applied on first load |
| `Table::groupedPerPage()` | Page size while grouped |
| `Group::label()` | Group label |
| `Group::collapsible()` | Allow collapsing (default `true`) |
| `Group::getTitleFromRecordUsing()`, `titleAttribute()` | Group title |
| `Group::getDescriptionFromRecordUsing()`, `descriptionAttribute()` | Group description |
| `Group::orderQueryUsing()` | Order the query by the group column (default `true`) |
