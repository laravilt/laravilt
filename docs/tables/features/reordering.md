---
title: Reordering
description: Let users reorder rows with drag and drop.
order: 5
---

# Reordering

```php
$table
    ->reorderable('sort_order')
    ->defaultSort('sort_order', 'asc');
```

The column defaults to `sort_order`. It must be an integer column on the model:

```php
Schema::create('menu_items', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->integer('sort_order')->default(0);
    $table->timestamps();
});
```

For resources, the panel registers a `POST {resource}/reorder` route that saves the new order. Outside a resource, point the table at your own endpoint with `reorderRoute()`:

```php
$table
    ->reorderable('position')
    ->reorderRoute(route('menu-items.reorder'));
```

The endpoint receives `items` and `column` in the request body.

## API reference

| Method | Description |
|--------|-------------|
| `reorderable(?string $column = 'sort_order')` | Enable drag-and-drop ordering |
| `reorderRoute(string $route)` | Custom URL that saves the order |
