---
title: Installation
description: Generate a new plugin or install an existing one.
order: 1
---

# Installation

## Generate a plugin

```bash
# Interactive
php artisan laravilt:plugin

# With a name and vendor
php artisan laravilt:plugin BlogManager --vendor=laravilt
```

| Argument / option | Description |
|-------------------|-------------|
| `name` | Plugin name (asked for if omitted) |
| `--vendor=` | Vendor name (asked for if omitted) |
| `--path=` | Base path. Defaults to `packages/{vendor}/{kebab-name}` |
| `--no-plugin` | Plain Laravel package without a plugin class |
| `--no-assets` | Skip asset scaffolding |

The command asks which features to include:

- Laravilt plugin class (panel integration)
- Database migrations
- Blade views
- Web routes and API routes
- CSS assets (Tailwind CSS v4)
- JavaScript assets (Vite)
- `arts/` folder with a cover image
- Language files
- GitHub workflows and issue templates
- PHPStan
- Custom Composer details (author, email, license)
- Initialize a Git repository, run `composer install`, run tests

Defaults for vendor, author, email, license and GitHub sponsor come from `config/laravilt-plugins.php` (`LARAVILT_PLUGINS_DEFAULT_*` env keys). Publish it with:

```bash
php artisan vendor:publish --tag=laravilt-plugins-config
```

> `laravilt:make` looks for plugins in `packages/laravilt/{name}`. Use `--vendor=laravilt` if you want to generate components with it.

## Load the plugin in your app

Add the local package to your application's `composer.json` and require it:

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

## Install an existing plugin

```bash
composer require vendor/plugin-name
php artisan migrate
```

Many plugins ship an install command, for example `php artisan laravilt:users:install`.

## Register it on a panel

```php
use Vendor\PluginName\PluginNamePlugin;

$panel->plugins([
    PluginNamePlugin::make(),
]);
```

## Related

- [Structure](structure.md)
- [Creating a plugin](../tutorials/creating-a-plugin.md)
