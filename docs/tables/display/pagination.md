---
title: Pagination
description: Configure page size, page size options, and infinite scroll.
order: 1
---

# Pagination

Tables are paginated by default with 12 records per page.

```php
$table
    ->perPage(25)
    ->paginationPageOptions([10, 25, 50, 100]);
```

Passing an array to `paginated()` sets the options and uses the first one as the page size:

```php
$table->paginated([25, 50, 100]);
```

## First and last page links

```php
$table->extremePaginationLinks();
```

## Infinite scroll

```php
$table
    ->infiniteScroll()
    ->perPage(20);
```

Infinite scroll turns off while [grouping](../features/grouping.md) is active.

## Disable pagination

```php
$table->paginated(false);
```

## API reference

| Method | Description |
|--------|-------------|
| `paginated(bool\|array)` | Enable/disable, or set page size options |
| `perPage(int)` | Records per page (default 12) |
| `paginationPageOptions(array)` | Page size selector options |
| `extremePaginationLinks()` | Show first/last page buttons |
| `infiniteScroll()` | Load more on scroll |
