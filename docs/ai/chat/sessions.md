---
title: Sessions
description: Persist chat conversations with the AISession model.
order: 2
---

# Sessions

Conversations are stored in the `ai_sessions` table through `Laravilt\AI\Models\AISession`. The primary key is a UUID string.

| Column | Type | Description |
|--------|------|-------------|
| `id` | string (UUID) | Session ID |
| `user_id` | integer | Owner (relation `user()` uses `auth.providers.users.model`) |
| `title` | string | Session title |
| `provider` | string | Provider name |
| `model` | string | Model name |
| `messages` | array | Message list (`role`, `content`) |
| `metadata` | array | Extra data |

## Working with sessions

```php
use Illuminate\Support\Str;
use Laravilt\AI\AIManager;
use Laravilt\AI\Models\AISession;

$session = AISession::create([
    'id' => (string) Str::uuid(),
    'user_id' => auth()->id(),
    'title' => 'Product questions',
    'provider' => 'openai',
    'model' => 'gpt-4o-mini',
    'messages' => [],
]);

$session->addMessage('user', 'Hello!');
$session->addMessage('assistant', 'Hi! How can I help?');

$session->getLastMessage();   // ['role' => 'assistant', ...]
$session->getMessageCount();  // 2
$session->clearMessages();

// Continue a conversation
$response = app(AIManager::class)->provider($session->provider)->chat([
    ...$session->messages,
    ['role' => 'user', 'content' => 'What were we talking about?'],
]);
```

## Endpoints

| Method | URI | Description |
|--------|-----|-------------|
| GET | `/laravilt-ai/sessions` | Latest 50 sessions for the current user |
| POST | `/laravilt-ai/sessions` | Create (`title`, `provider`, `model`) |
| GET | `/laravilt-ai/sessions/{id}` | Show a session |
| PATCH | `/laravilt-ai/sessions/{id}` | Update `title` or `messages` |
| DELETE | `/laravilt-ai/sessions/{id}` | Delete a session |

When `session_id` is passed to `/laravilt-ai/chat` or `/laravilt-ai/stream`, the last user message and the assistant reply are appended to the session.

## Pruning old sessions

```php
AISession::where('updated_at', '<', now()->subDays(30))->delete();
```
