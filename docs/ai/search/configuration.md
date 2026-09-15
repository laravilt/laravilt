---
title: Configuration
description: Configure global search on a panel and register searchable resources.
order: 1
---

# Search Configuration

## Panel builder

`$panel->globalSearch()` receives a `Laravilt\AI\Builders\GlobalSearchBuilder`:

```php
use Laravilt\AI\Builders\GlobalSearchBuilder;

$panel->globalSearch(function (GlobalSearchBuilder $search) {
    $search->enabled()
        ->withAI()
        ->limit(5)
        ->maxResults(25)
        ->debounce(300)
        ->shortcut('cmd+k')
        ->exclude(['logs']);
});
```

| Method | Default | Description |
|--------|---------|-------------|
| `enabled(bool)` / `disabled()` | enabled | Toggle search |
| `withAI(bool)` / `withoutAI()` | off | Use AI to understand queries |
| `limit(int)` | `5` | Results per resource |
| `maxResults(int)` | `25` | Total results |
| `debounce(int)` | `300` | Input debounce in milliseconds |
| `shortcut(string)` | `cmd+k` | Keyboard shortcut |
| `endpoint(string)` | `{panel}/global-search` | Search endpoint URL |
| `using(Closure)` | none | Custom search handler |
| `exclude(array)` | `[]` | Resources to leave out |

## Config defaults

`config/laravilt-ai.php` also has a `global_search` section:

```php
'global_search' => [
    'enabled' => true,
    'limit' => 5,
    'use_ai' => true,
],
```

## GlobalSearch service

`Laravilt\AI\GlobalSearch` is the search engine behind the `/laravilt-ai/search` endpoint. You can use it directly:

```php
use App\Models\Product;
use Laravilt\AI\GlobalSearch;

$results = app(GlobalSearch::class)
    ->registerResource(
        resource: 'products',
        model: Product::class,
        searchable: ['name', 'sku', 'description'],
        label: 'Products',
        icon: 'Package',
        url: '/admin/products/{id}',
    )
    ->limit(5)
    ->useAI()
    ->search('laptops under $1000');
```

`search()` returns a collection of groups, each with `resource`, `label`, `icon` and `results`.

## Endpoint

```
GET /laravilt-ai/search?query=laptop
GET /laravilt-ai/search/resources
```

Both routes use the `web` and `auth` middleware.
