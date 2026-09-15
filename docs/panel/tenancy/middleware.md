---
title: Middleware & Routing
description: How tenants are identified per request and how tenant routes are named.
order: 5
---

# Middleware & Routing

## Middleware

All middleware lives in `Laravilt\Panel\Middleware`.

### InitializeTenancyBySubdomain

Used in multi-database mode:

1. Extracts the subdomain from the host
2. Rejects reserved subdomains
3. Finds the tenant by domain or slug
4. Switches to the tenant database
5. Sets the tenant context

### IdentifyTenant

Used in single-database mode:

1. Reads the tenant from the route parameter
2. Checks the user can access it
3. Sets the tenant context (no database switch)

### PreventAccessFromCentralDomains

Blocks tenant-only routes when they're requested on a central domain.

## Route Naming

| Context | Name prefix | Example |
|---------|-------------|---------|
| Panel routes | `{panel}.` | `admin.dashboard` |
| Subdomain (multi-database) routes | `{panel}.subdomain.` | `admin.subdomain.dashboard` |

## Multiple Panels

Each panel configures tenancy on its own:

```php
use App\Models\Team;
use Laravilt\Panel\Models\Tenant;

// Admin panel: multi-database
$panel->multiDatabaseTenancy(Tenant::class, 'myapp.com');

// Portal panel: single-database
$panel->tenant(Team::class);

// Marketing panel: no tenancy call at all
```

## Checking State

```php
$panel->hasTenancy();
$panel->isMultiDatabaseTenancy();
$panel->isSingleDatabaseTenancy();
```

## Next Steps

- [Best Practices](best-practices.md)
