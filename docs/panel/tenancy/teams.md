---
title: Teams Tenancy
description: Use a Team model as the tenant in single-database mode.
order: 2
---

# Teams Tenancy

Use a `Team` model as the tenant.

## Quick Start

Publish the teams migration, model and trait, then migrate:

```bash
php artisan vendor:publish --tag=laravilt-teams-migration
php artisan vendor:publish --tag=laravilt-teams-model   # app/Models/Team.php
php artisan vendor:publish --tag=laravilt-teams-trait   # app/Concerns/HasTeams.php
php artisan migrate
```

## User Model Setup

```php
namespace App\Models;

use App\Concerns\HasTeams;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravilt\Panel\Contracts\HasDefaultTenant;
use Laravilt\Panel\Contracts\HasTenants;

class User extends Authenticatable implements HasTenants, HasDefaultTenant
{
    use HasTeams;

    protected $fillable = [
        'name',
        'email',
        'password',
        'current_team_id',
    ];
}
```

`HasTeams` provides `teams()`, `currentTeam()`, `getTenants()`, `canAccessTenant()`, `getDefaultTenant()`, `ownsTeam()`, `teamRole()`, `hasTeamRole()` and `switchTeam()`.

## Team Model Setup

The published `Team` model implements the tenant contracts:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravilt\Panel\Contracts\HasTenantAvatar;
use Laravilt\Panel\Contracts\HasTenantName;

class Team extends Model implements HasTenantName, HasTenantAvatar
{
    public function getTenantName(): string
    {
        return $this->name;
    }

    public function getTenantAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }
}
```

## Panel Configuration

```php
use App\Models\Team;

public function panel(Panel $panel): Panel
{
    return $panel
        ->tenant(Team::class, 'team', 'slug')
        ->tenantRegistration()
        ->tenantProfile();
}
```

Team owners manage the team name and members under `/{panel}/tenant-settings`.

## Required Interfaces

| Interface | Methods |
|-----------|---------|
| `Laravilt\Panel\Contracts\HasTenants` (user) | `getTenants(Panel $panel)`, `canAccessTenant(Model $tenant)` |
| `Laravilt\Panel\Contracts\HasDefaultTenant` (user) | `getDefaultTenant(Panel $panel)` |
| `Laravilt\Panel\Contracts\HasTenantName` (tenant) | `getTenantName()` |
| `Laravilt\Panel\Contracts\HasTenantAvatar` (tenant) | `getTenantAvatarUrl()` |

## Next Steps

- [Configuration](configuration.md)
- [Best Practices](best-practices.md)
