---
title: Plugin Classes
description: The PluginProvider base class and the Plugin contract.
order: 1
---

# Plugin Classes

## PluginProvider

Extend `Laravilt\Plugins\PluginProvider`. It already implements `Laravilt\Plugins\Contracts\Plugin`.

```php
namespace Laravilt\BlogManager;

use Laravilt\Panel\Panel;
use Laravilt\Plugins\PluginProvider;

class BlogManagerPlugin extends PluginProvider
{
    protected static string $id = 'blog-manager';

    protected static string $name = 'Blog Manager';

    protected static string $version = '1.0.0';

    protected static string $description = 'Blog management';

    protected static string $author = 'Laravilt';

    public function register(Panel $panel): void
    {
        $panel->resources([
            Resources\Posts\PostResource::class,
        ]);

        $panel->pages([
            Pages\BlogDashboard::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        // Optional: runs after register()
    }
}
```

`register()` is abstract and required. `boot()` is optional.

## Properties

| Property | Required | Default |
|----------|----------|---------|
| `protected static string $id` | Yes | none, must be unique |
| `protected static string $name` | No | `''` |
| `protected static string $version` | No | `'1.0.0'` |
| `protected static string $description` | No | `''` |
| `protected static string $author` | No | `''` |
| `protected bool $enabled` | No | `true` |

## Methods

| Method | Returns | Description |
|--------|---------|-------------|
| `make()` | `static` | Create an instance |
| `getId()` | `string` | Plugin ID |
| `getName()` | `string` | Display name |
| `getVersion()` | `string` | Version |
| `getDescription()` | `string` | Description |
| `getAuthor()` | `string` | Author |
| `isEnabled()` | `bool` | Whether the plugin is enabled |
| `enable()` / `disable()` | `static` | Toggle the plugin |
| `register(Panel $panel)` | `void` | Register components on the panel |
| `boot(Panel $panel)` | `void` | Panel-specific boot logic |

## The Plugin contract

`Laravilt\Plugins\Contracts\Plugin` requires `getId()`, `register(Panel)`, `boot(Panel)`, `isEnabled()` and `static make()`. `Panel::plugin()` and `Panel::plugins()` accept any object that implements it.

## Related

- [Traits](traits.md)
- [Configuration](configuration.md)
