---
title: Sorting
description: Make columns sortable and set the default sort.
order: 2
---

# Sorting

```php
use Laravilt\Tables\Columns\TextColumn;

TextColumn::make('name')->sortable();
TextColumn::make('created_at')->sortable();
```

## Default sort

Without configuration, tables sort by `id` descending.

```php
$table->defaultSort('created_at', 'desc');
```

## API reference

| Method | Description |
|--------|-------------|
| `Column::sortable()` | Allow sorting by this column |
| `Table::defaultSort($column, $direction = 'asc')` | Initial sort column and direction |
