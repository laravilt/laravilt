---
title: DeepSeek
description: Use DeepSeek chat, coder and reasoner models with Laravilt AI.
order: 4
---

# DeepSeek Provider

`Laravilt\AI\Providers\DeepSeekProvider` uses the OpenAI-compatible DeepSeek API (`https://api.deepseek.com/v1`).

## Configuration

```env
DEEPSEEK_API_KEY=...
DEEPSEEK_MODEL=deepseek-chat
# Optional
DEEPSEEK_BASE_URL=
DEEPSEEK_TEMPERATURE=0.7
DEEPSEEK_MAX_TOKENS=2048
```

## Models

`Laravilt\AI\Enums\DeepSeekModel`:

| Case | Value |
|------|-------|
| `DEEPSEEK_CHAT` | `deepseek-chat` (default) |
| `DEEPSEEK_CODER` | `deepseek-coder` |
| `DEEPSEEK_REASONER` | `deepseek-reasoner` |

## Usage

```php
use Laravilt\AI\AIManager;

$response = app(AIManager::class)->provider('deepseek')->chat([
    ['role' => 'system', 'content' => 'You are an expert Laravel developer.'],
    ['role' => 'user', 'content' => 'Create a Post model with a category relation'],
], [
    'model' => 'deepseek-coder',
]);

echo $response['content'];
```

Switch to the reasoning model per call with `['model' => 'deepseek-reasoner']`.
