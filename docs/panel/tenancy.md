# Multi-Tenancy

Laravilt Panel provides built-in support for multi-tenancy, allowing you to build SaaS applications with either a shared database or isolated databases per tenant.

## Overview

Laravilt supports two tenancy modes:

| Mode | Description | Routing | Use Case |
|------|-------------|---------|----------|
| **Single Database** | All tenants share one database with `tenant_id` scoping | Path-based: `/panel/{tenant}/...` | Simple multi-tenant apps |
| **Multi-Database** | Each tenant has their own database | Subdomain: `tenant.domain.com/panel/...` | True SaaS isolation |

## Tenancy Modes

### Single Database Mode (Default)

All tenants share the same database. Data isolation is achieved through a `tenant_id` column on tenant-specific tables.

```php
use Laravilt\Panel\Panel;
use App\Models\Team;

Panel::make('admin')
    ->path('admin')
    ->tenant(Team::class, 'team', 'slug');
```

**Routing Pattern:** `/admin/{team}/dashboard`

**Best For:**
- Small to medium apps with few tenants
- When database management overhead should be minimal
- When tenants may need to share some data

### Multi-Database Mode

Each tenant gets their own database with complete data isolation. Tenants are identified by subdomain.

```php
use Laravilt\Panel\Panel;
use Laravilt\Panel\Models\Tenant;

Panel::make('admin')
    ->path('admin')
    ->multiDatabaseTenancy(Tenant::class, 'myapp.com');
```

**Routing Pattern:** `acme.myapp.com/admin/dashboard`

**Best For:**
- Enterprise SaaS applications
- Strict data isolation requirements
- Compliance-heavy industries (HIPAA, SOC2)
- Per-tenant backups and migrations

## Configuration

### Panel Configuration

```php
use Laravilt\Panel\Panel;
use Laravilt\Panel\Models\Tenant;
use Laravilt\Panel\Tenancy\TenancyMode;

Panel::make('admin')
    ->path('admin')
    // Option 1: Using multiDatabaseTenancy() helper
    ->multiDatabaseTenancy(Tenant::class, 'myapp.com')

    // Option 2: Using individual methods
    // ->tenant(Tenant::class)
    // ->tenancyMode(TenancyMode::MultiDatabase)
    // ->tenantDomain('myapp.com')

    // Configure model mappings
    ->tenantModels([
        \App\Models\Customer::class,
        \App\Models\Product::class,
        \App\Models\Order::class,
    ])
    ->centralModels([
        \App\Models\User::class,
        \App\Models\Plan::class,
    ])

    // Enable tenant features
    ->tenantRegistration()    // Allow new tenant signup
    ->tenantProfile()         // Enable team settings page
    ->tenantMenu()            // Show tenant switcher menu
    ->tenantMenuItems([
        'settings' => 'Team Settings',
        'billing' => 'Billing',
    ]);
```

### Configuration File

Publish the tenancy configuration:

```bash
php artisan vendor:publish --tag=laravilt-tenancy-config
```

This creates `config/laravilt-tenancy.php`:

```php
return [
    // Default tenancy mode: 'single' or 'multi'
    'mode' => env('TENANCY_MODE', 'single'),

    // Central database configuration
    'central' => [
        'connection' => env('DB_CONNECTION', 'mysql'),
        'domains' => [
            'localhost',
            '127.0.0.1',
            env('APP_CENTRAL_DOMAIN', 'localhost'),
        ],
    ],

    // Tenant database configuration
    'tenant' => [
        'database_prefix' => env('TENANT_DB_PREFIX', 'tenant_'),
        'database_suffix' => env('TENANT_DB_SUFFIX', ''),
        'migrations_path' => database_path('migrations/tenant'),
        'connection_template' => env('TENANT_DB_CONNECTION', 'mysql'),
    ],

    // Model configuration
    'models' => [
        'tenant' => \Laravilt\Panel\Models\Tenant::class,
        'domain' => \Laravilt\Panel\Models\Domain::class,
        'central' => [],  // Models using central database
        'tenant' => [],   // Models using tenant database
    ],

    // Provisioning settings
    'provisioning' => [
        'auto_create_database' => true,
        'auto_migrate' => true,
        'auto_seed' => false,
        'seeder' => null,
        'queue' => false,
        'queue_name' => 'default',
    ],

    // Subdomain settings
    'subdomain' => [
        'domain' => env('APP_DOMAIN', 'localhost'),
        'reserved' => ['www', 'api', 'admin', 'app', 'mail', 'ftp'],
    ],

    // Cache settings for tenant resolution
    'cache' => [
        'enabled' => true,
        'ttl' => 3600,
        'prefix' => 'laravilt_tenant_',
    ],
];
```

### Environment Variables

```env
# Tenancy mode
TENANCY_MODE=multi

# Base domain for subdomains
APP_DOMAIN=myapp.com
APP_CENTRAL_DOMAIN=myapp.com

# Database prefixes
TENANT_DB_PREFIX=tenant_
TENANT_DB_SUFFIX=

# Database connection for tenants
TENANT_DB_CONNECTION=mysql
```

## Models

### Tenant Model

The `Tenant` model represents an organization/team in your SaaS application:

```php
use Laravilt\Panel\Models\Tenant;

// Create a new tenant
$tenant = Tenant::create([
    'name' => 'Acme Corp',
    'slug' => 'acme',           // Used for subdomain routing
    'email' => 'admin@acme.com',
    'owner_id' => $user->id,
]);

// The following are auto-generated:
// - $tenant->id (ULID)
// - $tenant->database (tenant_acme)
```

**Key Attributes:**

| Attribute | Type | Description |
|-----------|------|-------------|
| `id` | string (ULID) | Primary key, auto-generated |
| `name` | string | Display name |
| `slug` | string | URL-friendly identifier, used for subdomain |
| `email` | string | Contact email |
| `avatar` | string | Avatar path |
| `description` | string | Optional description |
| `owner_id` | int | Owner user ID |
| `database` | string | Database name (auto-generated) |
| `data` | array | Arbitrary JSON data |
| `settings` | array | Tenant settings |
| `trial_ends_at` | datetime | Trial expiration date |

**Model Methods:**

```php
// Relationships
$tenant->owner;              // BelongsTo User
$tenant->users();            // BelongsToMany Users
$tenant->domains();          // HasMany Domains
$tenant->primaryDomain();    // Get primary Domain

// User management
$tenant->addUser($user, 'admin');  // Roles: owner, admin, member
$tenant->removeUser($user);
$tenant->isOwner($user);
$tenant->isAdmin($user);
$tenant->isMember($user);

// Settings
$tenant->getSetting('feature.enabled', false);
$tenant->setSetting('feature.enabled', true);

// Data storage
$tenant->getData('billing.plan');
$tenant->setData('billing.plan', 'pro');

// Trial status
$tenant->onTrial();          // bool
$tenant->trialEnded();       // bool

// Display
$tenant->getTenantName();    // Implements HasTenantName
$tenant->getTenantAvatarUrl(); // Implements HasTenantAvatar
```

### Domain Model

The `Domain` model maps domains/subdomains to tenants:

```php
use Laravilt\Panel\Models\Domain;

// Create a subdomain for a tenant
$domain = Domain::createSubdomain(
    tenant: $tenant,
    subdomain: 'acme',
    baseDomain: 'myapp.com',
    isPrimary: true
);

// Find tenant by domain
$tenant = Domain::findTenantByDomain('acme.myapp.com');
```

**Key Attributes:**

| Attribute | Type | Description |
|-----------|------|-------------|
| `domain` | string | Full domain (e.g., `acme.myapp.com`) |
| `tenant_id` | string | Foreign key to tenant |
| `is_primary` | bool | Whether this is the primary domain |
| `is_verified` | bool | Domain verification status |
| `verified_at` | datetime | When domain was verified |

**Model Methods:**

```php
$domain->tenant;                    // Get the tenant
$domain->makePrimary();             // Set as primary domain
$domain->verify();                  // Mark as verified
$domain->isSubdomainOf('myapp.com'); // Check subdomain
$domain->getSubdomain('myapp.com');  // Extract subdomain part
```

## Middleware

Laravilt provides middleware for tenant resolution and initialization:

### InitializeTenancyBySubdomain

This middleware handles subdomain-based tenant resolution for multi-database mode:

```php
// Automatically applied to multi-database panels
// Extracts subdomain from request host
// Resolves tenant from database
// Initializes tenant database connection
```

**Flow:**
1. Extract subdomain from request host (`acme.myapp.com` -> `acme`)
2. Check if subdomain is reserved
3. Find tenant by domain or slug
4. Initialize tenant database connection
5. Set tenant in `Laravilt` facade
6. Continue with request

### IdentifyTenant

Used for single-database tenancy to identify tenant from route parameter:

```php
// Applied to single-database panels
// Reads tenant from URL segment
// Sets tenant without changing database
```

### IdentifyPanel

Identifies the current panel from the route:

```php
// Sets the current panel context
// Used for both tenancy modes
```

## Route Naming

Laravilt uses distinct route name prefixes to avoid conflicts:

| Context | Route Prefix | Example |
|---------|--------------|---------|
| Subdomain routes | `{panel}.subdomain.` | `admin.subdomain.dashboard` |
| Central tenant settings | `{panel}.tenant.settings.` | `admin.tenant.settings.profile` |
| Central routes | `{panel}.` | `admin.dashboard` |

### Example Routes

```php
// Multi-database (subdomain) panel
route('admin.subdomain.dashboard');        // acme.myapp.com/admin
route('admin.subdomain.settings.profile'); // acme.myapp.com/admin/settings/profile

// Central panel routes
route('admin.dashboard');                  // myapp.com/admin
route('admin.tenant.settings.profile');    // myapp.com/admin/tenant/settings/profile
```

## Panel Methods Reference

### Tenancy Configuration

| Method | Description |
|--------|-------------|
| `tenant(Model, ?relationship, ?slug)` | Enable single-database tenancy |
| `multiDatabaseTenancy(Model, domain)` | Enable multi-database tenancy |
| `tenancyMode(TenancyMode\|string)` | Set tenancy mode explicitly |
| `tenantDomain(string)` | Set base domain for subdomains |
| `tenantSlugAttribute(string)` | Set slug attribute for URLs |
| `tenantOwnershipRelationship(string)` | Set user-tenant relationship name |
| `tenantRoutePrefix(string)` | Set tenant route prefix |

### Model Configuration

| Method | Description |
|--------|-------------|
| `tenantModels(array)` | Models that use tenant database |
| `centralModels(array)` | Models that use central database |

### Features

| Method | Description |
|--------|-------------|
| `tenantRegistration(bool\|string)` | Enable tenant signup page |
| `tenantProfile(bool\|string)` | Enable team settings page |
| `tenantBillingProvider(mixed)` | Set billing integration |
| `tenantMenu(bool)` | Enable/disable tenant switcher |
| `tenantMenuItems(array)` | Customize tenant menu items |

### Checking State

| Method | Description |
|--------|-------------|
| `hasTenancy()` | Check if tenancy is enabled |
| `isMultiDatabaseTenancy()` | Check if using multi-database mode |
| `isSingleDatabaseTenancy()` | Check if using single-database mode |
| `hasTenantRegistration()` | Check if registration is enabled |
| `hasTenantProfile()` | Check if profile page is enabled |
| `hasTenantMenu()` | Check if tenant menu is enabled |

### Getters

| Method | Description |
|--------|-------------|
| `getTenantModel()` | Get tenant model class |
| `getTenantDomain()` | Get base domain |
| `getTenancyMode()` | Get TenancyMode enum |
| `getTenantSlugAttribute()` | Get slug attribute name |
| `getTenantOwnershipRelationship()` | Get ownership relationship |
| `getTenantModels()` | Get tenant model classes |
| `getCentralModels()` | Get central model classes |
| `getTenantUrl(tenant, path)` | Build URL for tenant |

## Working with Tenants

### Getting Current Tenant

```php
use Laravilt\Panel\Facades\Laravilt;

// Get current tenant
$tenant = Laravilt::getTenant();

// Check if tenant is set
if (Laravilt::hasTenant()) {
    $name = Laravilt::getTenant()->name;
}
```

### Setting Tenant Programmatically

```php
use Laravilt\Panel\Facades\Laravilt;
use Laravilt\Panel\Models\Tenant;

$tenant = Tenant::find($id);
Laravilt::setTenant($tenant);
```

### TenantManager

For more control over tenant context:

```php
use Laravilt\Panel\TenantManager;

$manager = new TenantManager();

$manager->setTenant($tenant);
$manager->hasTenant();     // true
$manager->getTenant();     // Tenant model
$manager->getTenantId();   // Tenant ID
$manager->setTenant(null); // Clear tenant
```

## Database Migrations

### Central Migrations

Located in `database/migrations/` (default location):

```php
// Create tenants table
Schema::create('tenants', function (Blueprint $table) {
    $table->string('id')->primary();
    $table->string('name');
    $table->string('slug')->unique();
    $table->string('email')->nullable();
    $table->string('avatar')->nullable();
    $table->text('description')->nullable();
    $table->foreignId('owner_id')->nullable();
    $table->string('database')->nullable();
    $table->json('data')->nullable();
    $table->json('settings')->nullable();
    $table->timestamp('trial_ends_at')->nullable();
    $table->timestamps();
    $table->softDeletes();
});

// Create domains table
Schema::create('domains', function (Blueprint $table) {
    $table->id();
    $table->string('domain')->unique();
    $table->string('tenant_id');
    $table->boolean('is_primary')->default(false);
    $table->boolean('is_verified')->default(false);
    $table->timestamp('verified_at')->nullable();
    $table->timestamps();

    $table->foreign('tenant_id')->references('id')->on('tenants');
});

// Create tenant_users pivot table
Schema::create('tenant_users', function (Blueprint $table) {
    $table->id();
    $table->string('tenant_id');
    $table->foreignId('user_id');
    $table->string('role')->default('member');
    $table->json('permissions')->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamp('joined_at')->nullable();
    $table->timestamps();

    $table->foreign('tenant_id')->references('id')->on('tenants');
    $table->unique(['tenant_id', 'user_id']);
});
```

### Tenant Migrations

Located in `database/migrations/tenant/`:

```php
// Example tenant migration
Schema::create('customers', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email');
    // No tenant_id needed - entire database is tenant-scoped
    $table->timestamps();
});
```

## Multi-Panel Support

You can have multiple panels with different tenancy modes:

```php
// Admin panel with multi-database tenancy
Panel::make('admin')
    ->path('admin')
    ->multiDatabaseTenancy(Tenant::class, 'admin.myapp.com');

// Customer portal with single-database tenancy
Panel::make('portal')
    ->path('portal')
    ->tenant(Team::class);

// Marketing site with no tenancy
Panel::make('marketing')
    ->path('');
```

Each panel maintains independent tenant configuration:

```php
$adminPanel->isMultiDatabaseTenancy();   // true
$portalPanel->isMultiDatabaseTenancy();  // false
$portalPanel->isSingleDatabaseTenancy(); // true
```

## Best Practices

### 1. Use Environment-Based Configuration

```env
# Development
TENANCY_MODE=single
APP_DOMAIN=localhost

# Production
TENANCY_MODE=multi
APP_DOMAIN=myapp.com
```

### 2. Implement Custom Tenant Model

Extend the base model for custom logic:

```php
namespace App\Models;

use Laravilt\Panel\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant
{
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function isSubscribed(): bool
    {
        return $this->subscriptions()->active()->exists();
    }
}
```

### 3. Cache Tenant Resolution

The built-in caching is enabled by default. For high-traffic sites, consider Redis:

```php
// config/laravilt-tenancy.php
'cache' => [
    'enabled' => true,
    'ttl' => 3600,
    'prefix' => 'tenant_',
],
```

### 4. Reserved Subdomains

Always configure reserved subdomains to prevent conflicts:

```php
'subdomain' => [
    'reserved' => [
        'www', 'api', 'admin', 'app', 'mail',
        'ftp', 'webmail', 'cpanel', 'support',
        'help', 'docs', 'status', 'blog',
    ],
],
```

### 5. Tenant-Aware Queues

For multi-database mode, ensure queue jobs maintain tenant context:

```php
class ProcessOrder implements ShouldQueue
{
    public function __construct(
        public string $tenantId,
        public int $orderId,
    ) {}

    public function handle()
    {
        $tenant = Tenant::find($this->tenantId);
        Laravilt::setTenant($tenant);

        // Process order in tenant context
    }
}
```

## Troubleshooting

### Tenant Not Found

If tenants aren't being resolved:

1. Check domain configuration matches your environment
2. Verify DNS is configured for subdomains
3. Clear tenant cache: `php artisan cache:clear`
4. Check `domains` table has correct entries

### Database Connection Issues

If tenant database connections fail:

1. Verify database credentials in tenant config
2. Check database exists (if auto_create_database is false)
3. Verify database user has correct permissions
4. Check connection template configuration

### Route Name Conflicts

If routes conflict between panels:

1. Use unique panel IDs
2. Subdomain routes use `{panel}.subdomain.*` prefix
3. Central routes use `{panel}.tenant.*` prefix
4. Verify route registration order

## Next Steps

- [Creating Panels](creating-panels.md) - Learn panel configuration
- [Resources](resources.md) - Build CRUD resources
- [Pages](pages.md) - Create custom pages
- [Navigation](navigation.md) - Configure panel navigation
