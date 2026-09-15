---
title: Post-Migration Checklist
description: Review, register and test your code after migrating from Filament.
order: 3
---

# Post-Migration Checklist

## 1. Review Generated Files

```bash
ls -la app/Laravilt/Admin/Resources/
```

## 2. Check the Panel Provider

If your panel provider uses `discoverAutomatically()` (the default from `laravilt:install` and `laravilt:panel`), migrated classes in `app/Laravilt/Admin` are picked up automatically. Otherwise, register them:

```php
namespace App\Providers\Laravilt;

use Laravilt\Panel\Panel;
use Laravilt\Panel\PanelProvider;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->resources([
                \App\Laravilt\Admin\Resources\User\UserResource::class,
                \App\Laravilt\Admin\Resources\Post\PostResource::class,
            ]);
    }
}
```

## 3. Build Frontend Assets

```bash
npm run build
```

## 4. Test CRUD Operations

Test create, read, update and delete for every migrated resource. Check that resources declare `protected static string $model` and `protected static int $navigationSort` with those exact types.

## 5. Remove Filament (Optional)

```bash
composer remove filament/filament
```

## Manual Adjustments

### Custom Livewire Components

Laravilt uses Inertia instead of Livewire. Rewrite custom Livewire views as Vue components (`.vue`) or React components (`.tsx`), depending on your stack.

> React support requires Laravilt v1.1 or later.

### Complex Relationships

Review relation managers and consider [nested resources](../resources/nested-resources.md) for deep hierarchies.

### Custom Actions

Review actions with complex logic.

### Plugins

Filament plugins are not converted. Check the [plugins](../../plugins/README.md) section for Laravilt equivalents.

## Troubleshooting

### Source directory does not exist

```bash
ls app/Filament/Resources/
```

Pass `--source` if your Filament classes live elsewhere.

### Namespace Conflicts

Use `--force` to overwrite existing files, or merge by hand. Run with `--dry-run` first to preview.

### Missing Icon Mappings

```php
// Update manually with a Lucide icon name
protected static ?string $navigationIcon = 'Star';
```

## Next Steps

- [Migration Overview](overview.md)
- [Namespace Mappings](namespace-mappings.md)
