---
title: Tenancy Configuration
description: Panel tenancy methods, the laravilt-tenancy config file and environment variables.
order: 3
---

# Tenancy Configuration

## Panel Configuration

```php
use Laravilt\Panel\Models\Tenant;

public function panel(Panel $panel): Panel
{
    return $panel
        ->multiDatabaseTenancy(Tenant::class, 'myapp.com')
        ->tenantModels([
            \App\Models\Customer::class,
            \App\Models\Product::class,
        ])
        ->centralModels([
            \App\Models\User::class,
            \App\Models\Plan::class,
        ])
        ->tenantRegistration()
        ->tenantProfile()
        ->tenantMenu();
}
```

## Panel Methods

| Method | Description |
|--------|-------------|
| `tenant(Model, ?relationship, ?slugAttribute)` | Enable single-database tenancy |
| `tenancy(?Model)` | Enable tenancy without extra options |
| `tenantOwnershipRelationship()` | Relationship linking records to the tenant |
| `tenantSlugAttribute()` | Attribute used in the tenant URL segment |
| `tenantRoutePrefix()` | Prefix before the tenant segment |
| `multiDatabaseTenancy(Model, domain)` | Enable multi-database tenancy on a base domain |
| `tenancyMode()`, `tenantDomain()` | Set the mode or domain explicitly |
| `tenantModels(array)` | Models stored in the tenant database |
| `centralModels(array)` | Models stored in the central database |
| `tenantRegistration()` | Enable tenant sign-up |
| `tenantProfile()` | Enable tenant settings |
| `tenantMenu()`, `tenantMenuItems()` | Tenant switcher and its extra items |
| `tenantBillingProvider()` | Billing integration |

## Configuration File

Publish with `php artisan vendor:publish --tag=laravilt-tenancy-config` to `config/laravilt-tenancy.php`:

```php
return [
    'mode' => env('TENANCY_MODE', 'single'),   // single | multi

    'central' => [
        'connection' => env('DB_CONNECTION', 'mysql'),
        'domains' => ['localhost', '127.0.0.1', env('APP_CENTRAL_DOMAIN', 'localhost'), env('APP_DOMAIN', 'localhost')],
    ],

    'tenant' => [
        'database_prefix' => env('TENANT_DB_PREFIX', 'tenant_'),
        'database_suffix' => env('TENANT_DB_SUFFIX', ''),
        'migrations_path' => database_path('migrations/tenant'),
        'connection_template' => env('TENANT_DB_CONNECTION', env('DB_CONNECTION', 'mysql')),
    ],

    'models' => [
        'tenant' => \Laravilt\Panel\Models\Tenant::class,
        'domain' => \Laravilt\Panel\Models\Domain::class,
        'central' => [],
        'tenant' => [],
    ],

    'provisioning' => [
        'auto_create_database' => true,
        'auto_migrate' => true,
        'auto_seed' => false,
        'seeder' => null,
        'queue' => false,
        'queue_name' => 'default',
    ],

    'subdomain' => [
        'domain' => env('APP_DOMAIN', 'localhost'),
        'reserved' => ['www', 'api', 'admin', 'app', /* ... */],
    ],
];
```

## Environment Variables

```env
TENANCY_MODE=multi
APP_DOMAIN=myapp.com
APP_CENTRAL_DOMAIN=myapp.com
TENANT_DB_PREFIX=tenant_
TENANT_DB_SUFFIX=
TENANT_DB_CONNECTION=mysql
```

## Next Steps

- [Tenant Models](models.md)
- [Middleware & Routing](middleware.md)
