---
title: Agents
description: Resource-aware AI agents with columns, permissions and tools.
order: 4
---

# AI Agents

Laravilt AI has two agent types:

- `Laravilt\AI\AIAgent`: the fluent configuration object a panel resource returns from `ai()`. It describes the model, columns, permissions, provider and tools, and is exported to the frontend.
- `Laravilt\AI\ResourceAgent` (extends the abstract `Laravilt\AI\Agent`): an executable agent that holds instructions and generated tools for a model. `AIAgent::toResourceAgent()` converts one into the other.

| Page | Description |
|------|-------------|
| [Resource agents](resource-agents.md) | Configure `ai()` on a panel resource |
| [AI columns](ai-columns.md) | Describe columns for the model |
| [Configuration](configuration.md) | Providers, models and defaults |

## ResourceAgent

```php
use App\Models\Product;
use Laravilt\AI\ResourceAgent;

$agent = ResourceAgent::make('product_agent')
    ->description('Manage products via AI')
    ->instructions('You help users manage products.')
    ->model(Product::class); // generates query/create/update/delete tools

$agent->getTools();
$agent->toArray();
```

Tools are generated inside `model()`. To skip them, call `autoGenerateTools(false)` before `model()`. `addTool()`, `tools()` and `metadata()` add more.
