---
title: Auth MCP
description: Local MCP server for authentication methods and events.
order: 5
---

# Auth MCP Server

`Laravilt\Auth\Mcp\LaraviltAuthServer` describes authentication methods and events and searches the auth docs.

## Register

```php
// routes/ai.php
use Laravel\Mcp\Facades\Mcp;
use Laravilt\Auth\Mcp\LaraviltAuthServer;

Mcp::local('laravilt-auth', LaraviltAuthServer::class);
```

```bash
php artisan mcp:start laravilt-auth
```

## Tools

| Tool | Arguments | Description |
|------|-----------|-------------|
| `list-auth-methods-tool` | none | Available authentication methods with features and configuration |
| `get-event-info-tool` | `event` (required) | Properties, usage and examples for an authentication event |
| `search-docs-tool` | `query` (required) | Search the auth documentation |

## Example prompts

```
"Which authentication methods does Laravilt support?"
"Tell me about the login event."
"How do I set up passkeys?"
```

## Related

- [Auth](../auth/README.md)
