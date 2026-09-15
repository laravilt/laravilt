---
title: Schemas MCP
description: Local MCP server that generates schema classes.
order: 4
---

# Schemas MCP Server

`Laravilt\Schemas\Mcp\LaraviltSchemasServer` generates schema (layout) classes and searches the schemas docs.

## Register

```php
// routes/ai.php
use Laravel\Mcp\Facades\Mcp;
use Laravilt\Schemas\Mcp\LaraviltSchemasServer;

Mcp::local('laravilt-schemas', LaraviltSchemasServer::class);
```

```bash
php artisan mcp:start laravilt-schemas
```

## Tools

### generate-schema-tool

Generates a new schema class (the same result as `php artisan make:schema`).

| Argument | Type | Required | Description |
|----------|------|----------|-------------|
| `name` | string | Yes | Schema class name (StudlyCase) |
| `force` | boolean | No | Overwrite an existing file |

### search-docs-tool

| Argument | Type | Required | Description |
|----------|------|----------|-------------|
| `query` | string | Yes | Search query |

## Example prompts

```
"Create a ProductSchema."
"How do I build a multi-step wizard?"
```

## Related

- [Schemas](../schemas/README.md)
