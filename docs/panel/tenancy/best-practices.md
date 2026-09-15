---
title: Tenancy Best Practices
description: Tips and troubleshooting for tenant-aware panels.
order: 6
---

# Tenancy Best Practices

## Environment Configuration

```env
# Development
TENANCY_MODE=single
APP_DOMAIN=localhost

# Production
TENANCY_MODE=multi
APP_DOMAIN=myapp.com
```

## Reserved Subdomains

Add any subdomains tenants must not claim in `config/laravilt-tenancy.php`:

```php
'subdomain' => [
    'reserved' => [
        'www', 'api', 'admin', 'app',
        'mail', 'ftp', 'webmail', 'cpanel',
        'support', 'help', 'docs', 'status',
    ],
],
```

## Provisioning in the Background

For faster sign-ups, queue tenant database creation:

```php
'provisioning' => [
    'queue' => true,
    'queue_name' => 'tenants',
],
```

## Tenant-Aware Queued Jobs

Queued jobs don't carry tenant context. Pass the tenant id and restore it:

```php
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravilt\Panel\Facades\Laravilt;
use Laravilt\Panel\Models\Tenant;

class ProcessOrder implements ShouldQueue
{
    public function __construct(
        public string $tenantId,
        public int $orderId,
    ) {}

    public function handle(): void
    {
        Laravilt::setTenant(Tenant::find($this->tenantId));

        // Process in tenant context
    }
}
```

## Troubleshooting

### User Has No Teams

1. Check the User implements `HasTenants` and `HasDefaultTenant`
2. Check the User uses the `HasTeams` trait
3. Check `current_team_id` is fillable
4. Verify the `team_user` pivot table exists

### Tenant Not Found

1. Check `APP_DOMAIN` and the panel's tenant domain
2. Verify DNS (wildcard record) for subdomains
3. Clear caches: `php artisan optimize:clear`
4. Check the `domains` table entries

### Database Connection Issues

1. Verify the tenant connection template (`TENANT_DB_CONNECTION`)
2. Check the tenant database exists (`php artisan tenants:migrate --tenant=<slug>`)
3. Verify the database user can create databases

## Next Steps

- [Overview](overview.md)
- [Troubleshooting](../../getting-started/troubleshooting.md)
