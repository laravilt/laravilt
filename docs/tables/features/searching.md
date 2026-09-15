---
title: Searching
description: Configure the global search box and which columns it searches.
order: 1
---

# Searching

The global search box is enabled by default. It searches every column marked `searchable()`.

```php
use Laravilt\Tables\Columns\TextColumn;

TextColumn::make('name')->searchable();
TextColumn::make('email')->searchable();
```

## Table options

```php
$table
    ->searchable()                        // pass false to hide the search box
    ->searchPlaceholder('Search users...');
```

## Search other database columns

Pass an array to search several database columns for one table column:

```php
TextColumn::make('full_name')
    ->searchable(['first_name', 'last_name']);
```

## Individual column search

```php
TextColumn::make('sku')
    ->searchable(isIndividual: true, isGlobal: false);
```

## API reference

| Method | Description |
|--------|-------------|
| `Table::searchable()` | Show or hide the global search box |
| `Table::searchPlaceholder()` | Placeholder text |
| `Column::searchable($condition, $isIndividual, $isGlobal)` | Mark a column searchable; `$condition` may be an array of database columns |
