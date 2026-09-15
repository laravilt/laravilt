---
title: Tenancy Overview
description: Choose between single-database and multi-database tenancy and enable it on a panel.
order: 1
---

# Multi-Tenancy Overview

Build SaaS applications with tenant isolation.

## Tenancy Modes

| Mode | Description | Routing |
|------|-------------|---------|
| **Single database** | Shared database, records scoped to a tenant | Path: `/admin/{tenant}/...` |
| **Multi-database** | Separate database per tenant | Subdomain: `{tenant}.myapp.com/admin/...` |

## Single-Database Mode

```php
use App\Models\Team;
use Laravilt\Panel\Panel;

public function panel(Panel $panel): Panel
{
    return $panel
        ->tenant(Team::class, 'team', 'slug')   // model, ownership relationship, slug attribute
        ->tenantRegistration()
        ->tenantProfile();
}
```

Resources are scoped to the current tenant automatically. See [Teams Tenancy](teams.md) for the full setup.

## Multi-Database Mode

Publish the config and migrations for the central `tenants`, `domains` and tenant-user tables:

```bash
php artisan vendor:publish --tag=laravilt-tenancy-config
php artisan vendor:publish --tag=laravilt-tenancy-migrations
php artisan migrate
```

```php
use Laravilt\Panel\Models\Tenant;
use Laravilt\Panel\Panel;

public function panel(Panel $panel): Panel
{
    return $panel->multiDatabaseTenancy(Tenant::class, 'myapp.com');
}
```

Manage tenants from the command line:

```bash
php artisan tenant:create "Acme Corp" --slug=acme --email=admin@acme.com --seed
php artisan tenants:migrate                 # All tenants
php artisan tenants:migrate --tenant=acme --fresh --seed
php artisan tenant:delete acme --keep-database
```

| Command | Options |
|---------|---------|
| `tenant:create {name}` | `--slug=`, `--email=`, `--domain=`, `--no-database`, `--no-migrate`, `--seed` |
| `tenants:migrate` | `--tenant=`, `--fresh`, `--seed`, `--seeder=`, `--force` |
| `tenant:delete {tenant}` | `--force`, `--keep-database` |

## When to Use Each Mode

**Single database:**
- Small to medium apps
- Minimal database overhead
- Tenants may share some data

**Multi-database:**
- Strict data isolation
- Compliance requirements
- Per-tenant backups or scaling

## Next Steps

- [Teams Tenancy](teams.md): teams as tenants
- [Configuration](configuration.md): detailed configuration
