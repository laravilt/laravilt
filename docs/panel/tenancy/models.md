---
title: Tenant Models
description: The Tenant and Domain models used by multi-database tenancy.
order: 4
---

# Tenant Models

## Tenant Model

`Laravilt\Panel\Models\Tenant` lives in the central database. It uses string (non-incrementing) keys and soft deletes.

```php
use Laravilt\Panel\Models\Tenant;

$tenant = Tenant::create([
    'name' => 'Acme Corp',
    'slug' => 'acme',
    'email' => 'admin@acme.com',
    'owner_id' => $user->id,
]);
```

With the default provisioning config, creating a tenant creates and migrates its database. The `php artisan tenant:create` command does the same from the CLI.

### Attributes

| Attribute | Type | Description |
|-----------|------|-------------|
| `id` | string | Primary key |
| `name` | string | Display name |
| `slug` | string | URL/subdomain identifier |
| `email` | string | Contact email |
| `avatar`, `description` | string | Profile data |
| `owner_id` | int | Owner user id |
| `database` | string | Database name |
| `data`, `settings` | array | Arbitrary data and settings |
| `trial_ends_at` | datetime | Trial end |

### Methods

```php
// Relationships
$tenant->owner;
$tenant->users();
$tenant->domains();
$tenant->primaryDomain();

// Membership
$tenant->addUser($user, 'admin');
$tenant->removeUser($user);
$tenant->isOwner($user);
$tenant->isAdmin($user);
$tenant->isMember($user);

// Settings & data
$tenant->getSetting('feature.enabled', false);
$tenant->setSetting('feature.enabled', true);
$tenant->getData('plan');

// Trials
$tenant->onTrial();
$tenant->trialEnded();
```

## Domain Model

```php
use Laravilt\Panel\Models\Domain;

$domain = Domain::createSubdomain(
    tenant: $tenant,
    subdomain: 'acme',
    baseDomain: 'myapp.com',
    isPrimary: true
);

$tenant = Domain::findTenantByDomain('acme.myapp.com');
```

## Getting the Current Tenant

```php
use Laravilt\Panel\Facades\Laravilt;

$tenant = Laravilt::getTenant();

if (Laravilt::hasTenant()) {
    $name = Laravilt::getTenant()->name;
}
```

The facade also provides `setTenant()`, `getTenantId()`, `getTenants()`, `canAccessTenant()` and `isTenancyEnabled()`.

## Next Steps

- [Middleware & Routing](middleware.md)
- [Best Practices](best-practices.md)
