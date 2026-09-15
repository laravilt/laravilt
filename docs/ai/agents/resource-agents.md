---
title: Resource Agents
description: Configure the AI agent of a panel resource.
order: 1
---

# Resource Agents

A panel resource gets AI capabilities when it overrides `ai()`. The agent passed in is already prepared by `Resource::makeAIAgent()`: its name is the resource slug, its model is the resource model, and it has a default description.

```php
namespace App\Laravilt\Admin\Resources\Product;

use Laravilt\AI\AIAgent;
use Laravilt\AI\AIColumn;
use Laravilt\Panel\Resources\Resource;

class ProductResource extends Resource
{
    public static function ai(AIAgent $agent): AIAgent
    {
        return $agent
            ->name('product_assistant')
            ->description('AI assistant for managing products')
            ->systemPrompt('You are a helpful product assistant.')
            ->searchable(['name', 'description', 'sku'])
            ->columns([
                AIColumn::make('name')->searchable(),
                AIColumn::make('price')->type('decimal')->sortable(),
                AIColumn::make('is_active')->type('boolean')->filterable(),
            ])
            ->canDelete(false);
    }
}
```

`php artisan laravilt:resource` can generate this for you. With the AI option it creates `Resources/{Model}/Ai/{Model}Ai.php` with a `configure(AIAgent $ai)` method, and the resource's `ai()` returns `{Model}Ai::configure($ai)`.

## Permissions

`canCreate`, `canUpdate`, `canDelete` and `canQuery` all default to `true`.

```php
$agent
    ->canCreate(auth()->user()->can('create', Product::class))
    ->canUpdate(auth()->user()->can('update', Product::class))
    ->canDelete(false)
    ->canQuery();
```

## Provider and model

```php
use Laravilt\AI\Enums\OpenAIModel;

$agent->provider('openai')->aiModel(OpenAIModel::GPT_4O);
```

## Custom tools

```php
$agent->tools([new WeatherTool('get_weather')]);
$agent->addTool($anotherTool);
```

See [Custom tools](../tools/custom-tools.md).

## Methods

| Method | Description |
|--------|-------------|
| `name(string)` | Agent name |
| `description(string)` | Agent description |
| `systemPrompt(string)` | System instructions |
| `model(string)` | Eloquent model class |
| `searchable(array)` | Searchable columns |
| `columns(array)` / `addColumn(AIColumn)` | AI column definitions |
| `tools(array)` / `addTool(Tool)` | Custom tools |
| `metadata(array)` | Extra data |
| `canCreate()`, `canUpdate()`, `canDelete()`, `canQuery()` | Permissions (default `true`) |
| `provider(string)` | Provider name |
| `aiModel(string\|BackedEnum)` | Model name or enum |
| `handler(Closure)` | Custom handler |
| `toResourceAgent()` | Convert to an executable `ResourceAgent` |
| `toArray()` | Export for the frontend |
