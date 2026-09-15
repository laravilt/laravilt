---
title: Dependencies
description: Depend on other packages and react to optional plugins.
order: 4
---

# Dependencies

## Composer dependencies

Declare hard dependencies in the plugin's `composer.json`:

```json
{
    "require": {
        "php": "^8.3",
        "laravilt/laravilt": "^1.0"
    }
}
```

## Optional plugins

Use the `LaraviltPlugins` facade to check whether another plugin is registered with the plugin manager:

```php
use Laravilt\Panel\Panel;
use Laravilt\Plugins\Facades\LaraviltPlugins;
use Laravilt\Plugins\PluginProvider;

class BlogManagerPlugin extends PluginProvider
{
    protected static string $id = 'blog-manager';

    public function register(Panel $panel): void
    {
        $panel->resources([
            Resources\Posts\PostResource::class,
        ]);

        if (LaraviltPlugins::has('comments')) {
            $panel->resources([
                Resources\Comments\CommentResource::class,
            ]);
        }
    }
}
```

`LaraviltPlugins::get('comments')` returns the plugin instance.

To check what is registered on a specific panel instead, use `$panel->getPlugin('comments')` or `$panel->getPlugins()`.

## Related

- [Plugin classes](plugin-classes.md)
- [Registration](../manager/registration.md)
