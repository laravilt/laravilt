---
title: Components
description: Generate resources, models, migrations and other classes inside a plugin.
order: 3
---

# Plugin Components

`laravilt:make` generates Laravel classes inside an existing plugin.

```bash
php artisan laravilt:make {plugin?} {type?} {name?}
```

Omitted arguments are asked for interactively. The plugin must live in `packages/laravilt/{plugin}` and its namespace is read from the plugin's `composer.json`.

| Page | Description |
|------|-------------|
| [Resources](resources.md) | Panel resources with schemas, tables and pages |
| [Models](models.md) | Eloquent models and factories |
| [Commands](commands.md) | Artisan commands |

## Types and output paths

| Type | Generates | Path |
|------|-----------|------|
| `resource` | Panel resource | `src/Resources/{Plural}/` |
| `model` | Eloquent model | `src/Models/` |
| `migration` | `create_{table}_table` migration | `database/migrations/` |
| `controller` | Controller | `src/Http/Controllers/` |
| `command` | Artisan command | `src/Commands/` |
| `job` | Queued job | `src/Jobs/` |
| `event` | Event | `src/Events/` |
| `listener` | Event listener | `src/Listeners/` |
| `notification` | Notification | `src/Notifications/` |
| `seeder` | Seeder | `database/seeders/` |
| `factory` | Model factory | `database/factories/` |
| `test` | Feature test | `tests/Feature/` |
| `lang` | Language file | `resources/lang/{name}/` |
| `route` | Route file | `routes/` |

## Examples

```bash
php artisan laravilt:make blog-manager model Post
php artisan laravilt:make blog-manager migration Post      # create_posts_table
php artisan laravilt:make blog-manager resource Post
php artisan laravilt:make blog-manager command SyncPosts
php artisan laravilt:make blog-manager test PostTest
php artisan laravilt:make blog-manager lang ar
```
