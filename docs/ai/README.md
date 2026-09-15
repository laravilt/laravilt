---
title: AI
description: Add AI chat, resource-aware agents, tool calling and AI-powered global search to Laravilt panels.
order: 11
---

# AI

The `laravilt/ai` package connects your Laravilt panels to large language models. It ships a provider layer (OpenAI, Anthropic, Gemini, DeepSeek, Perplexity), an AI chat page with streaming and saved sessions, per-resource agents, tool calling, and an AI-assisted global search spotlight. Vue and React frontends are both included.

> React support requires Laravilt v1.1 or later.

## Sections

| Section | What it covers |
|---------|----------------|
| [Providers](providers/README.md) | Configure OpenAI, Anthropic, Gemini, DeepSeek and Perplexity |
| [Chat](chat/README.md) | The AI chat page, streaming, sessions and frontend components |
| [Tools](tools/README.md) | Query, create, update, delete and custom tools for function calling |
| [Agents](agents/README.md) | Resource agents, AI columns and model selection |
| [Search](search/README.md) | AI-assisted global search (Cmd/Ctrl + K) |

## Installation

```bash
composer require laravilt/ai
php artisan laravilt:ai:install
```

`laravilt:ai:install` publishes `config/laravilt-ai.php` (tag `laravilt-ai-config`) and runs the migrations that create the `ai_sessions` table. Options:

| Option | Description |
|--------|-------------|
| `--force` | Overwrite the published config file |
| `--without-migrations` | Skip running migrations |

## Configuration

Set the default provider and at least one API key in `.env`:

```env
LARAVILT_AI_PROVIDER=openai

OPENAI_API_KEY=sk-...
OPENAI_MODEL=gpt-4o-mini

ANTHROPIC_API_KEY=sk-ant-...
ANTHROPIC_MODEL=claude-sonnet-4-20250514
```

Then enable AI and global search on a panel:

```php
use Laravilt\AI\Builders\AIProviderBuilder;
use Laravilt\AI\Builders\GlobalSearchBuilder;
use Laravilt\AI\Enums\OpenAIModel;
use Laravilt\AI\Providers\OpenAIProvider;

return $panel
    ->aiProviders(function (AIProviderBuilder $ai) {
        $ai->provider(OpenAIProvider::class, fn (OpenAIProvider $p) => $p->model(OpenAIModel::GPT_4O_MINI))
            ->default('openai');
    })
    ->globalSearch(function (GlobalSearchBuilder $search) {
        $search->enabled()->limit(5)->debounce(300);
    });
```

`php artisan laravilt:panel` can generate this for you when you pick the AI and global search features.

## Quick start

```php
use Laravilt\AI\AIManager;

$ai = app(AIManager::class);

$response = $ai->provider('openai')->chat([
    ['role' => 'user', 'content' => 'Hello!'],
]);

echo $response['content'];
```

## Related

- [Panel](../panel/README.md)
- [MCP servers](../mcp/README.md)
