---
title: AI Features FAQ
description: Questions about AI providers, resource AI agents and global search.
order: 6
---

# AI Features FAQ

## How do I enable AI features?

Set a default provider and its API key in `.env`:

```env
LARAVILT_AI_PROVIDER=openai
OPENAI_API_KEY=your-api-key
OPENAI_MODEL=gpt-4o-mini
```

Settings live in `config/laravilt-ai.php`.

## Which providers are supported?

| Provider | Key | API key variable | Default model |
|----------|-----|------------------|---------------|
| OpenAI | `openai` | `OPENAI_API_KEY` | `gpt-4o-mini` |
| Anthropic | `anthropic` | `ANTHROPIC_API_KEY` | `claude-sonnet-4-20250514` |
| Google Gemini | `gemini` | `GOOGLE_AI_API_KEY` | `gemini-2.0-flash-exp` |
| DeepSeek | `deepseek` | `DEEPSEEK_API_KEY` | `deepseek-chat` |
| Perplexity | `perplexity` | `PERPLEXITY_API_KEY` | `sonar` |

Each provider also reads `*_MODEL`, `*_BASE_URL`, `*_TEMPERATURE` and `*_MAX_TOKENS`. See [Providers](../ai/providers/README.md).

## How do I configure providers per panel?

```php
use Laravilt\AI\Builders\AIProviderBuilder;

$panel->aiProviders(fn (AIProviderBuilder $ai) => $ai
    ->openai()
    ->anthropic()
    ->default('openai'));
```

## How do I make a resource AI-aware?

Add an `ai()` method to the resource. `laravilt:resource` can generate an `{Model}Ai` class for you:

```php
use Laravilt\AI\AIAgent;
use Laravilt\AI\AIColumn;
use Laravilt\AI\Enums\OpenAIModel;
use Laravilt\AI\Providers\OpenAIProvider;

public static function ai(AIAgent $ai): AIAgent
{
    return $ai
        ->name('product_assistant')
        ->model(Product::class)
        ->provider(OpenAIProvider::class)
        ->aiModel(OpenAIModel::GPT_4O_MINI)
        ->systemPrompt('You help users manage products.')
        ->columns([
            AIColumn::make('name')->searchable(),
        ])
        ->canQuery()
        ->canCreate()
        ->canUpdate()
        ->canDelete();
}
```

See [Agents](../ai/agents/README.md).

## How do I call a provider from my own code?

Resolve the manager (`Laravilt\AI\AIManager`, also bound as `laravilt-ai`) and use the provider's `chat` methods:

```php
use Laravilt\AI\AIManager;

$provider = app(AIManager::class)->provider('anthropic');

$response = $provider->chat([
    ['role' => 'user', 'content' => 'Summarize this order...'],
]);

foreach ($provider->streamChat($messages) as $chunk) {
    // stream chunks
}
```

## How do I write a custom tool?

Extend `Laravilt\AI\Tools\Tool` and implement `handle()`. See [Custom Tools](../ai/tools/custom-tools.md).

## Related

- [AI Documentation](../ai/README.md)
- [Tools](../ai/tools/README.md)
