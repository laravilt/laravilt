---
title: Tools
description: Give AI models functions to call for querying and changing data.
order: 3
---

# AI Tools

Tools are functions a model can call through `chatWithTools()`. Every tool extends `Laravilt\AI\Tools\Tool`.

| Page | Description |
|------|-------------|
| [Query tool](query-tool.md) | Search and sort model records |
| [CRUD tools](crud-tools.md) | Create, update and delete records |
| [Custom tools](custom-tools.md) | Write your own tools |

## Built-in tools

| Class | Description |
|-------|-------------|
| `QueryTool` | Search and order records |
| `CreateTool` | Create a record from fillable fields |
| `UpdateTool` | Update a record by `id` |
| `DeleteTool` | Delete (soft or force) a record by `id` |
| `ResourceQueryTool` | Static helper behind the chat's `list_resources` and `query_resource` tools |

## Calling tools

Pass tool definitions (`$tool->toArray()`) to `chatWithTools()`, run the calls, then send the results back:

```php
use Laravilt\AI\AIManager;
use Laravilt\AI\ResourceAgent;
use App\Models\Product;

$agent = ResourceAgent::make('product_agent')->model(Product::class);
$tools = collect($agent->getTools())->keyBy(fn ($tool) => $tool->getName());

$response = app(AIManager::class)->provider()->chatWithTools(
    [['role' => 'user', 'content' => 'Find products under $50']],
    $tools->map->toArray()->values()->all(),
);

foreach ($response['tool_calls'] ?? [] as $call) {
    $result = $tools[$call['name']]->execute($call['arguments']);
}
```

Each tool call has `id`, `name` and decoded `arguments`.
