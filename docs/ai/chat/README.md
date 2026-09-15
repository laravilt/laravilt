---
title: Chat
description: The AI chat page with streaming answers, saved sessions and resource mentions.
order: 2
---

# AI Chat

Laravilt AI ships a full chat interface: the `Laravilt\AI\Pages\AIChat` panel page (slug `ai`, hidden from the sidebar) renders the `AIChat` component, and JSON endpoints under `/laravilt-ai` handle chat, streaming and sessions.

| Page | Description |
|------|-------------|
| [Streaming](streaming.md) | Server-sent events and realtime callbacks |
| [Sessions](sessions.md) | Persisted conversations in `ai_sessions` |
| [Frontend components](frontend-components.md) | `AIChat` for Vue and React |

## Features

- Streaming responses
- Saved sessions with a sidebar
- Provider and model selection from the panel's configured providers
- `@` mentions that focus the answer on specific resources
- Markdown rendering, copy buttons and dark mode

## Enabling chat

Configure at least one provider on the panel:

```php
use Laravilt\AI\Builders\AIProviderBuilder;

$panel->aiProviders(function (AIProviderBuilder $ai) {
    $ai->openai()->default('openai');
});
```

The chat page receives the panel's `aiConfig` and `hasAI` props.

## Resource context

When a message is streamed, the server adds a system message that lists the panel's resources, their record counts and fields. The model can call two built-in tools (`Laravilt\AI\Tools\ResourceQueryTool`):

- `list_resources`: list available resources
- `query_resource`: list, count or fetch records from a resource

Mentioning a resource with `@` (for example `@Products`) sends it as `mentioned_resources` so the answer focuses on it.

## Endpoints

All routes use the `web` and `auth` middleware and the `/laravilt-ai` prefix.

| Method | URI | Description |
|--------|-----|-------------|
| GET | `/laravilt-ai/config` | Configured providers and models |
| POST | `/laravilt-ai/chat` | Single JSON response |
| POST | `/laravilt-ai/stream` | Server-sent events stream |
| GET, POST | `/laravilt-ai/sessions` | List or create sessions |
| GET, PATCH, DELETE | `/laravilt-ai/sessions/{id}` | Show, update or delete a session |
