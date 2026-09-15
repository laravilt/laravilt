---
title: Structure
description: The directory layout and naming conventions of a generated plugin.
order: 2
---

# Plugin Structure

A plugin generated with `php artisan laravilt:plugin BlogManager --vendor=laravilt` looks like this (optional folders only appear if you pick the feature):

```
packages/laravilt/blog-manager/
├── arts/
├── config/
│   └── blog-manager.php
├── database/
│   └── migrations/
├── resources/
│   ├── css/
│   ├── js/
│   ├── lang/
│   │   └── en/
│   └── views/
├── routes/
│   ├── web.php
│   └── api.php
├── src/
│   ├── BlogManagerPlugin.php
│   ├── BlogManagerServiceProvider.php
│   └── Commands/
│       └── InstallBlogManagerCommand.php
├── tests/
│   ├── Pest.php
│   └── TestCase.php
├── .github/
├── composer.json
├── package.json
├── phpstan.neon
├── pint.json
├── testbench.yaml
└── README.md
```

Components you generate later with `laravilt:make` add folders such as `src/Models`, `src/Resources`, `src/Http/Controllers`, `database/factories` and `database/seeders`.

## Key files

| File | Purpose |
|------|---------|
| `src/{Name}Plugin.php` | Plugin class that registers resources, pages and widgets on a panel |
| `src/{Name}ServiceProvider.php` | Laravel service provider: merges config, loads translations, migrations, views and routes, registers commands |
| `src/Commands/Install*Command.php` | Install command for the plugin |
| `config/*.php` | Plugin configuration |

> The generated plugin class may import `Filament\Contracts\Plugin` and `Filament\Panel`. Laravilt plugins should extend `Laravilt\Plugins\PluginProvider` and type-hint `Laravilt\Panel\Panel`, so update those imports if you see them.

## Naming conventions

| Item | Convention | Example |
|------|------------|---------|
| Plugin ID | kebab-case | `blog-manager` |
| Class name | StudlyCase | `BlogManagerPlugin` |
| Namespace | `Vendor\PluginName` | `Laravilt\BlogManager` |
| Directory | `packages/{vendor}/{kebab-name}` | `packages/laravilt/blog-manager` |

## Related

- [Installation](installation.md)
- [Plugin classes](../concepts/plugin-classes.md)
