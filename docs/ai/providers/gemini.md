---
title: Gemini
description: Use Google Gemini models with Laravilt AI.
order: 3
---

# Gemini Provider

`Laravilt\AI\Providers\GeminiProvider` talks to the Google Generative Language API (`v1beta`).

## Configuration

```env
GOOGLE_AI_API_KEY=...
GOOGLE_AI_MODEL=gemini-2.0-flash-exp
# Optional
GOOGLE_AI_BASE_URL=
GOOGLE_AI_TEMPERATURE=0.7
GOOGLE_AI_MAX_TOKENS=2048
```

## Models

`Laravilt\AI\Enums\GeminiModel`:

| Case | Value |
|------|-------|
| `GEMINI_2_FLASH` | `gemini-2.0-flash-exp` (default) |
| `GEMINI_15_PRO` | `gemini-1.5-pro` |
| `GEMINI_15_FLASH` | `gemini-1.5-flash` |
| `GEMINI_PRO` | `gemini-pro` |

## Usage

Send messages in the standard `role`/`content` format. The provider converts them to Gemini's format, including system messages. `temperature` and `max_tokens` map to Gemini's `temperature` and `maxOutputTokens`.

```php
use Laravilt\AI\AIManager;

$response = app(AIManager::class)->provider('gemini')->chat([
    ['role' => 'user', 'content' => 'Hello'],
    ['role' => 'assistant', 'content' => 'Hi!'],
    ['role' => 'user', 'content' => 'How are you?'],
], [
    'temperature' => 0.7,
    'max_tokens' => 2048,
]);

echo $response['content'];
```
