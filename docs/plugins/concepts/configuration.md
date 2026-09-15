---
title: Configuration
description: Plugin config files and fluent plugin options.
order: 3
---

# Configuration

## Config file

The generator creates `config/{plugin-id}.php`:

```php
return [
    'enabled' => env('BLOG_MANAGER_ENABLED', true),

    'posts_per_page' => env('BLOG_POSTS_PER_PAGE', 10),
];
```

The generated service provider merges it and publishes it under the `{plugin-id}-config` tag:

```php
public function register(): void
{
    $this->mergeConfigFrom(__DIR__.'/../config/blog-manager.php', 'blog-manager');
}

public function boot(): void
{
    $this->publishes([
        __DIR__.'/../config/blog-manager.php' => config_path('blog-manager.php'),
    ], 'blog-manager-config');
}
```

```php
config('blog-manager.posts_per_page');
```

## Fluent options

Add chainable setters to the plugin class so each panel can configure it:

```php
use Laravilt\Panel\Panel;
use Laravilt\Plugins\PluginProvider;

class BlogManagerPlugin extends PluginProvider
{
    protected static string $id = 'blog-manager';

    protected int $postsPerPage = 10;

    protected bool $allowComments = true;

    public function postsPerPage(int $count): static
    {
        $this->postsPerPage = $count;

        return $this;
    }

    public function allowComments(bool $enabled = true): static
    {
        $this->allowComments = $enabled;

        return $this;
    }

    public function register(Panel $panel): void
    {
        // Use $this->postsPerPage / $this->allowComments here
    }
}
```

```php
$panel->plugins([
    BlogManagerPlugin::make()
        ->postsPerPage(15)
        ->allowComments(false),
]);
```

## The plugins package config

`config/laravilt-plugins.php` controls discovery and generator defaults:

| Key | Description |
|-----|-------------|
| `discovery.enabled` | Auto-discover installed plugins (`LARAVILT_PLUGINS_DISCOVERY_ENABLED`) |
| `discovery.cache` | Cache discovery (`LARAVILT_PLUGINS_CACHE_ENABLED`) |
| `paths` | Paths to look for plugins (default `vendor`) |
| `defaults.*` | Vendor, author, email, license and GitHub sponsor for new plugins |
| `features` | Feature classes used by the generator; add your own |
