---
title: Plugins MCP
description: Local MCP server that lists, inspects and generates plugins.
order: 6
---

# Plugins MCP Server

`Laravilt\Plugins\Mcp\LaraviltPluginsServer` lets an AI agent discover, inspect and generate plugins and their components.

## Install

```bash
composer require laravel/mcp
php artisan laravilt:install-mcp
```

`laravilt:install-mcp` is only available when `laravel/mcp` is installed. It:

1. Publishes `routes/ai.php` (tag `ai-routes`) if it doesn't exist
2. Adds `Mcp::local('laravilt-plugins', LaraviltPluginsServer::class);` to it
3. Adds a `laravilt-plugins` entry (`php artisan mcp:start laravilt-plugins`) to `.mcp.json`

Restart your MCP client afterwards.

## Tools

| Tool | Arguments | Description |
|------|-----------|-------------|
| `list-plugins-tool` | none | Plugins in the `packages` directory |
| `plugin-info-tool` | `plugin` | Structure, features and configuration of a plugin |
| `plugin-structure-tool` | `plugin` | Full directory tree of a plugin |
| `generate-plugin-tool` | see below | Generate a new plugin |
| `generate-component-tool` | `plugin`, `type`, `name` | Generate a component inside a plugin |
| `list-component-types-tool` | none | Component types that can be generated |
| `search-docs-tool` | `query` | Search the plugins documentation |

### generate-plugin-tool

| Argument | Type | Description |
|----------|------|-------------|
| `name` | string (required) | Plugin name (StudlyCase) |
| `description` | string | Plugin description |
| `migrations`, `views`, `webRoutes`, `apiRoutes` | boolean | Include these features |
| `css`, `js`, `arts`, `github`, `phpstan` | boolean | Include assets, arts, GitHub files and PHPStan |

### generate-component-tool

`type` is one of `migration`, `model`, `controller`, `command`, `job`, `event`, `listener`, `notification`, `seeder`, `factory`, `test`, `lang`, `route`. To generate a panel resource, run `php artisan laravilt:make {plugin} resource {Name}`.

## Example prompts

```
"List all plugins."
"Create a BlogExtensions plugin with migrations and views."
"Add a Post model to blog-extensions."
```

## Related

- [Plugins](../plugins/README.md)
- [Plugin components](../plugins/components/README.md)
