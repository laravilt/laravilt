---
title: Configuration
description: Choose providers, models and safe defaults for agents.
order: 3
---

# Agent Configuration

Agents use the providers from `config/laravilt-ai.php` and the panel's `aiProviders()`. See [Providers](../providers/README.md) for the full config file.

```env
LARAVILT_AI_PROVIDER=openai

OPENAI_API_KEY=your-api-key
OPENAI_MODEL=gpt-4o-mini

ANTHROPIC_API_KEY=your-api-key
ANTHROPIC_MODEL=claude-sonnet-4-20250514

GOOGLE_AI_API_KEY=your-api-key
GOOGLE_AI_MODEL=gemini-2.0-flash-exp
```

## Model selection

```php
use Laravilt\AI\Enums\AnthropicModel;
use Laravilt\AI\Enums\OpenAIModel;

$agent->provider('openai')->aiModel(OpenAIModel::GPT_4O_MINI);

$agent->provider('anthropic')->aiModel(AnthropicModel::CLAUDE_SONNET_4);

// A plain string also works
$agent->aiModel('claude-sonnet-4-20250514');
```

`getAiModelValue()` returns the string value whether you passed an enum or a string.

## Temperature and tokens

Set these per provider with env keys (`OPENAI_TEMPERATURE`, `OPENAI_MAX_TOKENS`, and so on) or in code:

```php
use Laravilt\AI\Providers\OpenAIProvider;

$ai->provider(OpenAIProvider::class, fn (OpenAIProvider $p) => $p->temperature(0.3)->maxTokens(4096));
```

## Recommendations

- Use a small model (`gpt-4o-mini`, `claude-3-5-haiku`) for lookups and a larger one for reasoning.
- Every permission defaults to `true`, so turn off `canDelete()` (and others) unless you need them.
- Write a clear `systemPrompt()` per resource.
