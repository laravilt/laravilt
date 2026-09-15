---
title: Query Tool
description: Let the model search and sort Eloquent records.
order: 1
---

# Query Tool

`Laravilt\AI\Tools\QueryTool` runs a `LIKE` search over the columns you choose and returns the records as arrays.

```php
use App\Models\Product;
use Laravilt\AI\Tools\QueryTool;

$tool = QueryTool::make('search_products')
    ->description('Search and filter products')
    ->model(Product::class)
    ->searchableColumns(['name', 'description', 'sku'])
    ->limit(10);
```

## Parameters

Calling `model()` adds these parameters to the tool definition:

| Parameter | Type | Description |
|-----------|------|-------------|
| `search` | string | Search term matched against the searchable columns |
| `limit` | integer | Maximum results (defaults to `limit()`, 10 if not set) |
| `orderBy` | string | Column to sort by |
| `orderDirection` | string | `asc` or `desc` |

Example call from the model:

```json
{ "search": "laptop", "limit": 5, "orderBy": "price", "orderDirection": "asc" }
```

> The search is only applied when `searchableColumns()` is set.

## Methods

| Method | Description |
|--------|-------------|
| `make(string $name)` | Create the tool |
| `description(string)` | Description sent to the model |
| `model(string $class)` | Eloquent model to query |
| `searchableColumns(array)` | Columns used for `search` |
| `limit(int)` | Default result limit |
