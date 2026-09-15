---
title: Traits
description: Concerns that load a plugin's migrations, translations, views, assets and commands.
order: 2
---

# Plugin Traits

The concerns in `Laravilt\Plugins\Concerns` wrap Laravel's `ServiceProvider` helpers (`loadMigrationsFrom()`, `loadTranslationsFrom()`, `loadViewsFrom()`, `publishes()`, `commands()`). Use them in your plugin's **service provider**, not in the `PluginProvider` class.

```php
namespace Laravilt\BlogManager;

use Illuminate\Support\ServiceProvider;
use Laravilt\Plugins\Concerns\HasCommands;
use Laravilt\Plugins\Concerns\HasMigrations;
use Laravilt\Plugins\Concerns\HasTranslations;
use Laravilt\Plugins\Concerns\HasViews;

class BlogManagerServiceProvider extends ServiceProvider
{
    use HasCommands;
    use HasMigrations;
    use HasTranslations;
    use HasViews;

    public function boot(): void
    {
        $this->loadMigrations();
        $this->loadTranslations();

        $this->viewNamespace('blog-manager');
        $this->loadViews();

        $this->pluginCommands([
            Commands\InstallBlogManagerCommand::class,
        ]);
        $this->registerPluginCommands();
    }
}
```

The generated service provider already calls the plain Laravel helpers, so these traits are optional.

## Reference

| Trait | Methods |
|-------|---------|
| `HasMigrations` | `migrations(array)`, `getMigrations()`, `loadMigrations()` |
| `HasTranslations` | `translations(array $namespaces)`, `getTranslationNamespaces()`, `loadTranslations()` |
| `HasViews` | `viewNamespace(string)`, `getViewNamespace()`, `loadViews()`, `publishViews()` |
| `HasAssets` | `assets(array)`, `assetsPath(string)` (default `dist`), `getAssets()`, `getAssetsPath()`, `publishAssets()` |
| `HasCommands` | `pluginCommands(array)`, `getPluginCommands()`, `registerPluginCommands()` |
| `HasComponents` | `components(array)`, `getComponents()`, `registerComponents()` |
