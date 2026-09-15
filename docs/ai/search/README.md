---
title: Search
description: AI-assisted global search across panel resources.
order: 5
---

# Global Search

Global search is a spotlight dialog (Cmd/Ctrl + K) that searches every resource in the panel. With a configured AI provider, it can also understand natural-language questions.

| Page | Description |
|------|-------------|
| [Configuration](configuration.md) | Panel builder and the `GlobalSearch` service |
| [Frontend components](frontend-components.md) | `GlobalSearch` for Vue and React |

## Enable global search

```php
use Laravilt\AI\Builders\GlobalSearchBuilder;

$panel->globalSearch(function (GlobalSearchBuilder $search) {
    $search->enabled()
        ->withAI()
        ->limit(5)
        ->debounce(300);
});
```

The panel shares `hasGlobalSearch`, `globalSearchEndpoint` and `globalSearchConfig` with the frontend. The search component then appears in the top bar.

## How AI search works

Plain keyword queries search the database directly (or Laravel Scout, if the model uses it). When the query looks like a question and a provider is configured, the model either calls a query tool against the resources or extracts search terms, and those results are returned.

| Query | Result |
|-------|--------|
| `laptop` | Direct keyword search |
| `products under $50` | AI builds a resource query |
| `which orders are pending?` | AI extracts terms and searches |

## Keyboard shortcuts

| Shortcut | Action |
|----------|--------|
| Cmd + K / Ctrl + K | Open search |
| Up / Down | Move through results |
| Enter | Open the selected result |
| Esc | Close |
