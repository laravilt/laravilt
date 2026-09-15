---
title: Creating a Plugin
description: Build a plugin with a model, migration and resource, then register it on a panel.
order: 1
---

# Creating a Plugin

This guide builds a `blog-manager` plugin with a `Post` resource.

## Step 1: Generate the scaffold

```bash
php artisan laravilt:plugin BlogManager --vendor=laravilt
```

Select at least:

- Laravilt plugin
- Database migrations
- Language files

The plugin is created in `packages/laravilt/blog-manager`.

## Step 2: Load it in your app

In your application's `composer.json`:

```json
{
    "repositories": [
        { "type": "path", "url": "packages/laravilt/blog-manager" }
    ]
}
```

```bash
composer require laravilt/blog-manager:@dev
```

## Step 3: Generate components

```bash
php artisan laravilt:make blog-manager model Post
php artisan laravilt:make blog-manager migration Post
php artisan laravilt:make blog-manager resource Post
```

Edit the migration, add `$fillable` to the model, and point `PostResource::getModel()` to `Laravilt\BlogManager\Models\Post`. Then run:

```bash
php artisan migrate
```

## Step 4: Write the plugin class

```php
namespace Laravilt\BlogManager;

use Laravilt\Panel\Panel;
use Laravilt\Plugins\PluginProvider;

class BlogManagerPlugin extends PluginProvider
{
    protected static string $id = 'blog-manager';

    protected static string $name = 'Blog Manager';

    protected static string $version = '1.0.0';

    protected ?string $navigationGroup = null;

    public function navigationGroup(?string $group): static
    {
        $this->navigationGroup = $group;

        return $this;
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            Resources\Posts\PostResource::class,
        ]);
    }
}
```

Migrations and translations are loaded by the generated `BlogManagerServiceProvider`.

## Step 5: Register the plugin

```php
$panel->plugins([
    \Laravilt\BlogManager\BlogManagerPlugin::make()->navigationGroup('Content'),
]);
```

Open the panel and the Posts resource appears in the navigation.

## Related

- [Users plugin](../examples/users-plugin.md)
- [Plugin classes](../concepts/plugin-classes.md)
