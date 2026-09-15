---
title: Plugins
description: Build, generate and register reusable Laravilt plugins.
order: 13
---

# Plugins

The `laravilt/plugins` package lets you package resources, pages, widgets, migrations, translations and assets as reusable Composer packages. It provides the `PluginProvider` base class, generators for plugins and their components, a plugin manager with auto-discovery, and an MCP server for AI agents.

## Sections

| Section | What it covers |
|---------|----------------|
| [Getting started](getting-started/README.md) | Generate a plugin and learn its structure |
| [Concepts](concepts/README.md) | Plugin classes, traits, configuration and dependencies |
| [Components](components/README.md) | Generate resources, models, commands and more inside a plugin |
| [Plugin manager](manager/README.md) | The `LaraviltPlugins` facade and registration |
| [Tutorials](tutorials/README.md) | Build a plugin step by step |
| [Examples](examples/README.md) | The official `laravilt/users` plugin |

## Quick start

```bash
# Create a plugin in packages/{vendor}/{name}
php artisan laravilt:plugin BlogManager --vendor=laravilt

# Generate a component inside it
php artisan laravilt:make blog-manager model Post
```

## A minimal plugin

```php
namespace Laravilt\BlogManager;

use Laravilt\Panel\Panel;
use Laravilt\Plugins\PluginProvider;

class BlogManagerPlugin extends PluginProvider
{
    protected static string $id = 'blog-manager';

    protected static string $name = 'Blog Manager';

    public function register(Panel $panel): void
    {
        $panel->resources([
            Resources\Posts\PostResource::class,
        ]);
    }
}
```

Register it on a panel:

```php
$panel->plugins([
    \Laravilt\BlogManager\BlogManagerPlugin::make(),
]);
```

## Related

- [Plugins MCP server](../mcp/plugins.md)
- [Panel](../panel/README.md)
