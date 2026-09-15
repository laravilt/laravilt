---
title: OpenAI
description: Use OpenAI GPT and o1 models with Laravilt AI.
order: 1
---

# OpenAI Provider

`Laravilt\AI\Providers\OpenAIProvider` talks to the OpenAI Chat Completions API.

## Configuration

```env
OPENAI_API_KEY=sk-...
OPENAI_MODEL=gpt-4o-mini
# Optional
OPENAI_BASE_URL=
OPENAI_TEMPERATURE=0.7
OPENAI_MAX_TOKENS=2048
```

## Models

`Laravilt\AI\Enums\OpenAIModel`:

| Case | Value |
|------|-------|
| `GPT_4O` | `gpt-4o` |
| `GPT_4O_MINI` | `gpt-4o-mini` (default) |
| `GPT_4_TURBO` | `gpt-4-turbo` |
| `GPT_4` | `gpt-4` |
| `GPT_35_TURBO` | `gpt-3.5-turbo` |
| `O1` | `o1` |
| `O1_MINI` | `o1-mini` |
| `O1_PREVIEW` | `o1-preview` |

## Usage

```php
use Laravilt\AI\AIManager;

$ai = app(AIManager::class);

$response = $ai->provider('openai')->chat([
    ['role' => 'system', 'content' => 'You are a helpful assistant.'],
    ['role' => 'user', 'content' => 'Hello!'],
], [
    'model' => 'gpt-4o',
    'temperature' => 0.2,
    'max_tokens' => 1024,
]);

echo $response['content'];
print_r($response['usage']); // prompt_tokens, completion_tokens, total_tokens
```

## Streaming

```php
$ai->provider('openai')->streamChatRealtime($messages, function (string $chunk) {
    echo $chunk;
    flush();
});
```

See [Streaming](../chat/streaming.md) for details.
