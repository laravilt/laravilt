---
title: Anthropic
description: Use Anthropic Claude models with Laravilt AI.
order: 2
---

# Anthropic Provider

`Laravilt\AI\Providers\AnthropicProvider` talks to the Anthropic Messages API.

## Configuration

```env
ANTHROPIC_API_KEY=sk-ant-...
ANTHROPIC_MODEL=claude-sonnet-4-20250514
# Optional
ANTHROPIC_BASE_URL=
ANTHROPIC_TEMPERATURE=0.7
ANTHROPIC_MAX_TOKENS=2048
```

## Models

`Laravilt\AI\Enums\AnthropicModel`:

| Case | Value |
|------|-------|
| `CLAUDE_SONNET_4` | `claude-sonnet-4-20250514` (default) |
| `CLAUDE_OPUS_4` | `claude-opus-4-20250514` |
| `CLAUDE_35_SONNET` | `claude-3-5-sonnet-20241022` |
| `CLAUDE_35_HAIKU` | `claude-3-5-haiku-20241022` |
| `CLAUDE_3_OPUS` | `claude-3-opus-20240229` |
| `CLAUDE_3_SONNET` | `claude-3-sonnet-20240229` |
| `CLAUDE_3_HAIKU` | `claude-3-haiku-20240307` |

## Usage

Pass system instructions as a normal `system` message. The provider moves it into Anthropic's top-level `system` field for you.

```php
use Laravilt\AI\AIManager;

$response = app(AIManager::class)->provider('anthropic')->chat([
    ['role' => 'system', 'content' => 'You are an expert in Laravel.'],
    ['role' => 'user', 'content' => 'How do I eager load relations?'],
], [
    'max_tokens' => 4096,
]);

echo $response['content'];
```

## Streaming

```php
$ai->provider('anthropic')->streamChatRealtime($messages, fn (string $chunk) => print($chunk));
```
