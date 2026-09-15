---
title: Panel MCP
description: Local MCP server for panel features and resource structure.
order: 1
---

# Panel MCP Server

`Laravilt\Panel\Mcp\LaraviltPanelServer` answers questions about panel features, resources and pages.

## Register

```php
// routes/ai.php
use Laravel\Mcp\Facades\Mcp;
use Laravilt\Panel\Mcp\LaraviltPanelServer;

Mcp::local('laravilt-panel', LaraviltPanelServer::class);
```

```bash
php artisan mcp:start laravilt-panel
```

See [MCP servers](README.md) for the `laravel/mcp` setup.

## Tools

| Tool | Arguments | Description |
|------|-----------|-------------|
| `list-panel-features-tool` | none | Available panel features and their configuration options |
| `get-resource-info-tool` | none | Resource structure, properties and methods, with examples |
| `search-docs-tool` | `query` (required) | Search the panel documentation |

## Related generators

```bash
php artisan laravilt:panel
php artisan laravilt:page
php artisan laravilt:resource {panel?} --model= --table=
php artisan laravilt:relation {panel?} {resource?} {relationship?}
php artisan laravilt:cluster {panel} {name}
```

## Related

- [Panel](../panel/README.md)
