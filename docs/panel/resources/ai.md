---
title: Resource AI
description: Configure AI capabilities for resources
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
concept: resources
---

# Resource AI

Configure AI capabilities for your resources to enable AI-powered CRUD operations.

## Basic Configuration

```php
<?php

namespace App\Laravilt\Admin\Resources\Product;

use Laravilt\Panel\Resources\Resource;
use Laravilt\AI\AIAgent;
use Laravilt\AI\AIColumn;

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
use Laravilt\AI\AIAgent;

public static function ai(AIAgent $agent): AIAgent
{
    return $agent
        ->canCreate(true)
        ->canUpdate(true)
        ->canDelete(false)
        ->canQuery(true);
}
```

## Searchable Columns

```php
use Laravilt\AI\AIAgent;

public static function ai(AIAgent $agent): AIAgent
{
    return $agent
        ->searchable(['name', 'description', 'sku']);
}
```

## Custom Provider

```php
use Laravilt\AI\AIAgent;
use Laravilt\AI\Enums\OpenAIModel;

public static function ai(AIAgent $agent): AIAgent
{
    return $agent
        ->provider('openai')
        ->aiModel(OpenAIModel::GPT_4O);
}
```

## AIAgent Methods

| Method | Parameters | Description |
|--------|-----------|-------------|
| `name()` | `string` | Agent name |
| `description()` | `string` | Agent description |
| `systemPrompt()` | `string` | System prompt |
| `columns()` | `array` | AI columns |
| `searchable()` | `array` | Searchable fields |
| `canCreate()` | `bool` | Allow create |
| `canUpdate()` | `bool` | Allow update |
| `canDelete()` | `bool` | Allow delete |
| `canQuery()` | `bool` | Allow query |
| `provider()` | `string` | AI provider |
| `aiModel()` | `string` | AI model |
| `temperature()` | `float` | Response randomness |
| `maxTokens()` | `int` | Max response tokens |

## Related

- [AI Columns](ai-columns) - Define AI columns
