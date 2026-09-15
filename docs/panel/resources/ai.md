---
title: Resource AI
description: Give a resource an AI agent for natural-language querying, CRUD and global search.
order: 8
---

# Resource AI

Define an `ai()` method on a resource to let the panel's AI assistant query and manage its records. Configure AI providers on the panel with `->aiProviders()`. See the [AI section](../../ai/README.md).

## Basic Configuration

```php
<?php

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
            ->systemPrompt('You are a helpful product management assistant.')
            ->columns([
                AIColumn::make('name')
                    ->label('Product Name')
                    ->searchable(),
                AIColumn::make('price')
                    ->type('decimal')
                    ->filterable(),
            ]);
    }
}
```

## CRUD Permissions

```php
return $agent
    ->canQuery()
    ->canCreate()
    ->canUpdate()
    ->canDelete(false);
```

## Searchable Columns & Global Search

```php
return $agent->searchable(['name', 'description', 'sku']);
```

When the panel has `->globalSearch()` enabled, every resource with an AI agent and searchable columns shows up in global search.

## Custom Provider & Model

```php
use Laravilt\AI\Enums\OpenAIModel;

return $agent
    ->provider('openai')
    ->aiModel(OpenAIModel::GPT_4O);
```

## AIAgent Methods

| Method | Description |
|--------|-------------|
| `name()`, `description()` | Agent identity |
| `systemPrompt()` | System prompt |
| `columns()` / `addColumn()` | [AI columns](ai-columns.md) |
| `searchable()` | Searchable fields (also used by global search) |
| `canQuery()`, `canCreate()`, `canUpdate()`, `canDelete()` | Allowed operations |
| `provider()` | AI provider name |
| `aiModel()` / `model()` | Model (string or enum) |
| `tools()` / `addTool()` | Extra tools |
| `metadata()` | Extra metadata |
| `handler()` | Custom handler closure |

## Related

- [AI Columns](ai-columns.md)
