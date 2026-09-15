---
title: Providers
description: Configure the AI providers that power chat, agents and search.
order: 1
---

# AI Providers

Every provider implements `Laravilt\AI\Contracts\AIProvider` and extends `Laravilt\AI\Providers\BaseProvider`.

| Provider | Class | Default model | Page |
|----------|-------|---------------|------|
| OpenAI | `OpenAIProvider` | `gpt-4o-mini` | [OpenAI](openai.md) |
| Anthropic | `AnthropicProvider` | `claude-sonnet-4-20250514` | [Anthropic](anthropic.md) |
| Google Gemini | `GeminiProvider` | `gemini-2.0-flash-exp` | [Gemini](gemini.md) |
| DeepSeek | `DeepSeekProvider` | `deepseek-chat` | [DeepSeek](deepseek.md) |
| Perplexity | `PerplexityProvider` | `sonar` | [Perplexity](perplexity.md) |

## Config file

`config/laravilt-ai.php` (published by `php artisan laravilt:ai:install`):

```php
return [
    'default' => env('LARAVILT_AI_PROVIDER', 'openai'),

    'providers' => [
        'openai' => [
            'api_key' => env('OPENAI_API_KEY'),
            'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
            'base_url' => env('OPENAI_BASE_URL'),
            'temperature' => env('OPENAI_TEMPERATURE', 0.7),
            'max_tokens' => env('OPENAI_MAX_TOKENS', 2048),
        ],
        // anthropic, gemini, deepseek, perplexity follow the same shape
    ],

    'global_search' => ['enabled' => true, 'limit' => 5, 'use_ai' => true],
    'chat' => ['streaming' => true, 'max_history' => 100, 'show_token_usage' => false],
];
```

Each provider reads `api_key`, `model`, `base_url`, `temperature` and `max_tokens` from its entry.

## Using the AI manager

`Laravilt\AI\AIManager` builds a provider for every configured entry that has an API key.

```php
use Laravilt\AI\AIManager;

$ai = app(AIManager::class);

$ai->provider();               // default provider
$ai->provider('anthropic');    // throws InvalidArgumentException if not configured
$ai->hasProvider('gemini');
$ai->getProviders();           // configured providers keyed by name
$ai->isConfigured();
$ai->setDefault('anthropic');
```

> `AIManager` builds providers from config only for `openai`, `anthropic`, `gemini` and `deepseek`. To use Perplexity, register it on the panel with `AIProviderBuilder` or add it with `$ai->addProvider(new PerplexityProvider)`.

## Panel providers

A panel lists its providers with `aiProviders()`. The configure callback receives the provider instance:

```php
use Laravilt\AI\Builders\AIProviderBuilder;
use Laravilt\AI\Enums\AnthropicModel;
use Laravilt\AI\Providers\AnthropicProvider;

$panel->aiProviders(function (AIProviderBuilder $ai) {
    $ai->openai()
        ->provider(AnthropicProvider::class, fn (AnthropicProvider $p) => $p->model(AnthropicModel::CLAUDE_SONNET_4))
        ->perplexity()
        ->default('openai');
});
```

Shortcuts: `openai()`, `anthropic()`, `gemini()`, `deepseek()`, `perplexity()`.

## Provider methods

| Method | Description |
|--------|-------------|
| `apiKey(string)` | Set the API key |
| `model(string\|BackedEnum)` | Set the model (string or model enum) |
| `baseUrl(string)` | Override the API base URL |
| `temperature(float)` | Sampling temperature |
| `maxTokens(int)` | Maximum output tokens |
| `enabled()` / `disabled()` | Toggle the provider |
| `chat($messages, $options)` | Returns `['content' => ..., 'usage' => [...]]` |
| `chatWithTools($messages, $tools, $options)` | Adds `tool_calls` to the result |
| `streamChat($messages, $options)` | Generator of text chunks |
| `streamChatRealtime($messages, $callback, $options)` | Calls `$callback` for each chunk as it arrives |

Per-call `$options` accept `model`, `temperature` and `max_tokens` (OpenAI and DeepSeek also accept `tool_choice` in `chatWithTools()`).

Model enums live in `Laravilt\AI\Enums`: `OpenAIModel`, `AnthropicModel`, `GeminiModel`, `DeepSeekModel`, `PerplexityModel`.
