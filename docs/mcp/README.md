---
title: MCP
description: Connect AI agents to Laravilt with the hosted MCP server and the per-package local servers.
order: 15
---

# MCP Servers

Laravilt supports the [Model Context Protocol](https://modelcontextprotocol.io) (MCP) in two ways:

1. **The hosted Laravilt MCP server** at `https://mcp.laravilt.com/mcp`. It gives AI agents read-only access to the latest docs, READMEs, changelogs and versions of every Laravilt package. You install nothing.
2. **Local MCP servers** shipped inside individual packages. They run in your app through [`laravel/mcp`](https://laravel.com/docs/mcp) and can generate code in your project.

## Hosted server

**URL:** `https://mcp.laravilt.com/mcp` (streamable HTTP, public, read-only, rate limited per IP)

### Claude Code

```bash
claude mcp add --transport http laravilt https://mcp.laravilt.com/mcp
```

### Other MCP clients

Any client that supports remote HTTP servers (Cursor, VS Code, Claude Desktop, Windsurf and others) can use the URL. A typical `mcp.json` entry:

```json
{
  "mcpServers": {
    "laravilt": {
      "type": "http",
      "url": "https://mcp.laravilt.com/mcp"
    }
  }
}
```

### Tools

| Tool | Description |
|------|-------------|
| `list-packages` | Every `laravilt/*` package with description, latest version, release date, install command and GitHub URL |
| `get-package` | Details for one package: README summary, requirements, Vue/React support, docs index and recent changes |
| `search-docs` | Full-text search across all docs, READMEs and changelogs (`query`, optional `package`, `limit`) |
| `read-doc` | Read a full document (`package`, `path`, optional `page`) |
| `list-docs` | The documentation tree for one package, or all packages |
| `get-latest-versions` | Latest version of every package plus ready-to-paste `composer require` lines |
| `get-changelog` | Release history and changelog entries for a package (`package`, optional `limit`) |
| `installation-guide` | Step-by-step install for a new Laravel 13 app (`stack`: `vue` or `react`) |
| `plugin-development-guide` | Guide to building plugins with `laravilt:plugin` and `laravilt:make` |

The server also exposes the `laravilt-packages` and `laravilt-doc` resources and a `build-resource` prompt.

Example prompts:

```
"Which Laravilt packages exist and what are their latest versions?"
"Search the Laravilt docs for relation managers."
"How do I install Laravilt with React?"
```

## Local package servers

Several packages include an MCP server class in `src/Mcp`. They need `laravel/mcp`:

```bash
composer require laravel/mcp
php artisan vendor:publish --tag=ai-routes   # creates routes/ai.php
```

Register the servers you want in `routes/ai.php`:

```php
use Laravel\Mcp\Facades\Mcp;
use Laravilt\Forms\Mcp\LaraviltFormsServer;
use Laravilt\Laravilt\Mcp\LaraviltServer;

Mcp::local('laravilt', LaraviltServer::class);
Mcp::local('laravilt-forms', LaraviltFormsServer::class);
```

Then start one with `php artisan mcp:start laravilt-forms` or add it to your client's `.mcp.json`:

```json
{
  "mcpServers": {
    "laravilt-forms": {
      "command": "php",
      "args": ["artisan", "mcp:start", "laravilt-forms"]
    }
  }
}
```

`php artisan laravilt:install-mcp` (from `laravilt/plugins`) does all of this for the plugins server. See [Plugins MCP](plugins.md).

| Package | Server class | Tools | Page |
|---------|--------------|-------|------|
| `laravilt/laravilt` | `Laravilt\Laravilt\Mcp\LaraviltServer` | `list-packages-tool`, `package-info-tool`, `install-laravilt-tool`, `make-user-tool`, `search-docs-tool` | below |
| `laravilt/panel` | `Laravilt\Panel\Mcp\LaraviltPanelServer` | `search-docs-tool`, `list-panel-features-tool`, `get-resource-info-tool` | [Panel](panel.md) |
| `laravilt/forms` | `Laravilt\Forms\Mcp\LaraviltFormsServer` | `generate-form-tool`, `search-docs-tool` | [Forms](forms.md) |
| `laravilt/tables` | `Laravilt\Tables\Mcp\LaraviltTablesServer` | `generate-table-tool`, `search-docs-tool` | [Tables](tables.md) |
| `laravilt/schemas` | `Laravilt\Schemas\Mcp\LaraviltSchemasServer` | `generate-schema-tool`, `search-docs-tool` | [Schemas](schemas.md) |
| `laravilt/auth` | `Laravilt\Auth\Mcp\LaraviltAuthServer` | `search-docs-tool`, `get-event-info-tool`, `list-auth-methods-tool` | [Auth](auth.md) |
| `laravilt/plugins` | `Laravilt\Plugins\Mcp\LaraviltPluginsServer` | 7 plugin tools | [Plugins](plugins.md) |

Local tool names come from their class names (for example `GenerateFormTool` becomes `generate-form-tool`).

### Core server (laravilt/laravilt)

| Tool | Arguments | Description |
|------|-----------|-------------|
| `list-packages-tool` | none | Installed Laravilt packages and versions |
| `package-info-tool` | `package` | Details about one package |
| `install-laravilt-tool` | `force`, `skip_migrations`, `skip_npm` | Install and configure Laravilt |
| `make-user-tool` | `name`, `email`, `password` | Create an admin user |
| `search-docs-tool` | `query`, `package` | Search the bundled docs |

## Security

Local servers run with your application's permissions and can write files. Only register them in development and keep `.mcp.json` out of shared environments. The hosted server is read-only.

## Related

- [Laravel MCP](https://laravel.com/docs/mcp)
- [AI package](../ai/README.md)
