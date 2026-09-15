---
title: Query Builder
description: Apply request-driven filters and sorting to any Eloquent query.
order: 12
---

# Query Builder

`laravilt/query-builder` is a small, standalone helper. It applies filter values and sorting to an Eloquent `Builder`, and serializes its configuration to Inertia props so a frontend can render the controls. Use it for custom pages and endpoints. Resource tables have their own [table filters](../tables/filters/README.md).

```bash
composer require laravilt/query-builder
php artisan query-builder:install   # optional: --force, --without-assets
```

## Example

```php
use App\Models\Product;
use Laravilt\QueryBuilder\Filters\SelectFilter;
use Laravilt\QueryBuilder\Filters\TextFilter;
use Laravilt\QueryBuilder\QueryBuilder;
use Laravilt\QueryBuilder\Sort;

$builder = (new QueryBuilder)
    ->filters([
        TextFilter::make('name')->contains(),
        SelectFilter::make('status')
            ->options(['active' => 'Active', 'inactive' => 'Inactive']),
    ])
    ->sorts([
        Sort::make('name'),
        Sort::make('created_at')->defaultDirection('desc'),
    ])
    ->applyFilters($request->only(['name', 'status']))
    ->sortBy($request->input('sort', 'created_at'), $request->input('direction', 'desc'));

$products = $builder->apply(Product::query())->paginate(15);

return inertia('Products/Index', [
    'products' => $products,
    'query' => $builder->toInertiaProps(),
]);
```

`apply()` skips filters whose value is `null` or `''`, and returns the same builder so you can keep chaining.

## Methods

| Method | Description |
|--------|-------------|
| `filters(array)`, `addFilter(Filter)` | Register filters |
| `sorts(array)`, `addSort(Sort)` | Register sort options |
| `applyFilters(array)` | Filter values keyed by filter name |
| `sortBy(?string $column, ?string $direction = 'asc')` | Active sort (invalid directions become `asc`) |
| `search(?string)` | Store a search term (serialized only; add your own search constraint) |
| `perPage(int)`, `paginated(bool)` | Pagination settings passed to the frontend |
| `apply(Builder)` | Apply filters and sorting to a query |
| `toInertiaProps()` | Serialize filters, sorts, and current values |

## In this section

1. [Filters](filters/README.md): text, select, boolean, and date filters
2. [Sorting](sorting.md): sort options
