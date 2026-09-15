---
title: Discovery
description: Register resources, pages, clusters and widgets automatically or by hand.
order: 3
---

# Discovery

A panel only shows the resources, pages, clusters and widgets registered on it. You can let Laravilt discover them or register them yourself.

## Automatic Discovery

```php
public function panel(Panel $panel): Panel
{
    return $panel
        ->id('admin')
        ->discoverAutomatically();
}
```

For a panel with id `admin`, this scans:

- `app/Laravilt/Admin/Pages` (`App\Laravilt\Admin\Pages`)
- `app/Laravilt/Admin/Resources` (`App\Laravilt\Admin\Resources`)
- `app/Laravilt/Admin/Clusters` (`App\Laravilt\Admin\Clusters`)
- `app/Laravilt/Admin/Widgets` (`App\Laravilt\Admin\Widgets`)

It also scans `Modules/{Module}/Laravilt/Admin/...` in modular applications.

## Discovering Custom Directories

Each `discover*()` method takes a directory and its namespace:

```php
return $panel
    ->discoverPages(
        in: app_path('Laravilt/Admin/Pages'),
        for: 'App\\Laravilt\\Admin\\Pages'
    )
    ->discoverResources(
        in: app_path('Laravilt/Admin/Resources'),
        for: 'App\\Laravilt\\Admin\\Resources'
    )
    ->discoverClusters(
        in: app_path('Laravilt/Admin/Clusters'),
        for: 'App\\Laravilt\\Admin\\Clusters'
    )
    ->discoverWidgets(
        in: app_path('Laravilt/Admin/Widgets'),
        for: 'App\\Laravilt\\Admin\\Widgets'
    );
```

## Manual Registration

```php
use App\Laravilt\Admin\Pages\Dashboard;
use App\Laravilt\Admin\Resources\User\UserResource;

return $panel
    ->pages([
        Dashboard::class,
    ])
    ->resources([
        UserResource::class,
    ]);
```

`clusters([...])` and `widgets([...])` work the same way. Nested resources are not registered directly. They are picked up from their parent resource's `getNestedResources()`.

## Directory Structure

This is what the generators create (`laravilt:resource`, `laravilt:page`, `laravilt:cluster`, `laravilt:widget`):

```
app/Providers/Laravilt/AdminPanelProvider.php
app/Laravilt/Admin/
├── Pages/
│   └── Dashboard.php
├── Resources/
│   └── User/
│       ├── UserResource.php
│       ├── Form/UserForm.php
│       ├── Table/UserTable.php
│       ├── InfoList/UserInfoList.php
│       ├── RelationManagers/
│       └── Pages/
├── Clusters/
└── Widgets/
```

## Next Steps

- [Resources](resources/README.md): CRUD resources
- [Pages](pages/README.md): custom pages
- [Navigation](navigation/README.md): navigation configuration
