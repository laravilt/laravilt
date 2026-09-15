---
title: Features
description: Search, sorting, column visibility, grouping, reordering, fixed actions, and polling.
order: 4
---

# Features

Table-level behaviors, configured on the `Table` instance or on individual columns.

1. [Searching](searching.md): global and per-column search
2. [Sorting](sorting.md): sortable columns and the default sort
3. [Column Visibility](column-visibility.md): let users hide columns
4. [Grouping](grouping.md): group rows by a column
5. [Reordering](reordering.md): drag-and-drop row order
6. [Fixed Actions](fixed-actions.md): sticky actions column
7. [Polling](polling.md): auto-refresh

```php
$table
    ->searchable()
    ->defaultSort('created_at', 'desc')
    ->striped()
    ->hoverable()
    ->poll('30s');
```
