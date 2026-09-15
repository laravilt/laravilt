---
title: Streaming
description: Stream AI responses in PHP and consume the server-sent events endpoint.
order: 1
---

# Streaming

## Realtime callback

`streamChatRealtime()` calls your callback for each chunk as the provider sends it:

```php
use Laravilt\AI\AIManager;

$provider = app(AIManager::class)->provider('openai');

$provider->streamChatRealtime(
    [['role' => 'user', 'content' => 'Write a short story']],
    function (string $chunk) {
        echo $chunk;
        flush();
    },
    ['model' => 'gpt-4o-mini'],
);
```

## Generator

`streamChat()` returns a generator of chunks:

```php
foreach ($provider->streamChat($messages) as $chunk) {
    echo $chunk;
}
```

> Some providers (such as OpenAI) collect the full response before yielding from `streamChat()`. Use `streamChatRealtime()` when you need output as it arrives.

## The stream endpoint

`POST /laravilt-ai/stream` accepts:

| Field | Type | Description |
|-------|------|-------------|
| `messages` | array | `role` (`system`, `user`, `assistant`, `tool`) and `content` |
| `provider` | string | Optional provider name |
| `model` | string | Optional model |
| `session_id` | string | Optional session to save the exchange to |
| `mentioned_resources` | array | Optional resource slugs to focus on |

It responds with `text/event-stream`. Each event is a JSON object with `content` (or `error`), and the stream ends with `data: [DONE]`:

```
data: {"content":"Hello"}

data: {"content":" there"}

data: [DONE]
```

Before streaming, the controller lets the model call the resource tools (`list_resources`, `query_resource`) and then streams the final answer.

## Consuming the stream

The endpoint is a POST, so read it with `fetch` rather than `EventSource`:

```ts
const res = await fetch('/laravilt-ai/stream', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': csrfToken,
  },
  body: JSON.stringify({ messages }),
})

const reader = res.body!.getReader()
const decoder = new TextDecoder()

while (true) {
  const { value, done } = await reader.read()
  if (done) break
  for (const line of decoder.decode(value).split('\n')) {
    if (!line.startsWith('data: ') || line === 'data: [DONE]') continue
    const data = JSON.parse(line.slice(6))
    if (data.content) output += data.content
  }
}
```

The `useAI()` composable (Vue and React) wraps this for you; see [Frontend components](frontend-components.md).
