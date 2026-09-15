---
title: Tables MCP
description: Local MCP server that generates table classes.
order: 3
---

# Tables MCP Server

`Laravilt\Tables\Mcp\LaraviltTablesServer` generates table classes and searches the tables docs.

## Register

```php
// routes/ai.php
use Laravel\Mcp\Facades\Mcp;
use Laravilt\Tables\Mcp\LaraviltTablesServer;

Mcp::local('laravilt-tables', LaraviltTablesServer::class);
```

```bash
php artisan mcp:start laravilt-tables
```

## Tools

### generate-table-tool

Generates a new table class (the same result as `php artisan make:table`).

| Argument | Type | Required | Description |
|----------|------|----------|-------------|
| `name` | string | Yes | Table class name (StudlyCase) |
| `actions` | boolean | No | Include row and bulk actions |
| `force` | boolean | No | Overwrite an existing file |

### search-docs-tool

| Argument | Type | Required | Description |
|----------|------|----------|-------------|
| `query` | string | Yes | Search query |

## Example prompts

```
"Create a UserTable with actions."
"How do I add filters to a table?"
```

## Related

- [Tables](../tables/README.md)
