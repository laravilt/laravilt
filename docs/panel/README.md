---
title: Panel
description: The core Laravilt package that turns resources, pages and widgets into a complete admin panel.
order: 2
---

# Panel

The Panel package (`laravilt/panel`) is the core integration layer of Laravilt. A **panel** is a self-contained admin interface, served through Inertia v3 and rendered with either Vue 3 (shadcn-vue) or React 19 (shadcn/ui). Each panel has:

- **Resources**: CRUD screens for Eloquent models, built from forms, tables and infolists
- **Pages**: custom standalone screens
- **Navigation**: a sidebar generated from resources, pages and clusters
- **Authentication**: login, registration, 2FA, social login, passkeys, magic links and more
- **Widgets**: dashboard stats and charts
- **API and AI**: optional REST endpoints and AI agents for each resource
- **Tenancy**: single-database or multi-database multi-tenancy

You can run several panels side by side, for example an admin panel at `/admin` and a customer portal at `/portal`. Each panel is configured by its own provider in `app/Providers/Laravilt`.

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
            ->brandName('Admin')
            ->discoverAutomatically()
            ->login();
    }
}
```

With `discoverAutomatically()`, everything under `app/Laravilt/Admin/{Pages,Resources,Clusters,Widgets}` is registered for you.

## In this section

Read these in order:

1. [Creating Panels](creating-panels.md): generate a panel with `laravilt:panel`
2. [Panel Provider](panel-provider.md): the provider, the `Panel` facade, config and publishing
3. [Discovery](discovery.md): automatic and manual registration of components
4. [Branding & Theming](branding.md): name, logo, colors, fonts, dark mode and custom CSS
5. [Layout & Localization](layout.md): content width, locale, timezone and RTL
6. [Panel Authentication](panel-auth.md): enable auth features for a panel
7. [Resources](resources/README.md): CRUD resources, relation managers, nested resources, API and AI
8. [Pages](pages/README.md): custom pages with forms, tables, infolists and widgets
9. [Navigation](navigation/README.md): navigation properties, custom items, badges and clusters
10. [Multi-Tenancy](tenancy/README.md): single-database and multi-database tenancy
11. [Migrating from Filament](migration/README.md): convert a Filament v3/v4 app with `laravilt:filament`

## Related

- [Installation](../getting-started/installation.md)
- [Your First Resource](../getting-started/first-resource.md)
- [Forms](../forms/README.md), [Tables](../tables/README.md), [Infolists](../infolists/README.md), [Widgets](../widgets/README.md)
