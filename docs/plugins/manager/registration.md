---
title: Registration
description: Register plugins on panels and how auto-discovery works.
order: 1
---

# Registration

## Register on a panel

Add plugins in your panel provider with `plugins()` (or `plugin()` for one):

```php
namespace App\Providers\Laravilt;

use Laravilt\BlogManager\BlogManagerPlugin;
use Laravilt\Panel\Panel;
use Laravilt\Panel\PanelProvider;
use Laravilt\Users\UsersPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->plugins([
                BlogManagerPlugin::make(),
                UsersPlugin::make()->navigationGroup('Access')->navigationSort(5),
            ]);
    }
}
```

Plugins are keyed by `getId()`. Use `$panel->getPlugins()` and `$panel->getPlugin('blog-manager')` to read them back.

Fluent options such as `navigationGroup()` only exist if the plugin class defines them (see [Configuration](../concepts/configuration.md)).

## Conditional registration

```php
$panel->plugins(array_filter([
    BlogManagerPlugin::make(),
    config('app.enable_comments') ? CommentsPlugin::make() : null,
]));
```

## Several panels

Each panel gets its own plugin instance, so options can differ:

```php
$admin->plugins([BlogManagerPlugin::make()->allowComments()]);
$editor->plugins([BlogManagerPlugin::make()->allowComments(false)]);
```

## Auto-discovery

On boot, `PluginsServiceProvider` calls `discover()` and `bootAll()` on the plugin manager. Discovery reads `composer.lock` and picks up any class listed under `extra.laravel.providers` that implements `Laravilt\Plugins\Contracts\Plugin`. Discovered plugins are registered with the `LaraviltPlugins` manager.

Your plugin's Laravel service provider should still be listed in `extra.laravel.providers` so Laravel loads it:

```json
{
    "extra": {
        "laravel": {
            "providers": [
                "Laravilt\\BlogManager\\BlogManagerServiceProvider"
            ]
        }
    }
}
```

Registering the plugin on a panel with `$panel->plugins([...])` is what adds its resources, pages and widgets to that panel.
