---
title: Users Plugin
description: The official laravilt/users plugin for users, roles, permissions and impersonation.
order: 1
---

# Users Plugin Example

[`laravilt/users`](https://github.com/laravilt/users) is a production plugin that adds user and role management to a panel.

## Features

- User and role resources
- Role-based access control with `spatie/laravel-permission`
- Impersonation (opt-in)
- Avatars with `spatie/laravel-medialibrary` (opt-in)
- English and Arabic translations

## Installation

```bash
composer require laravilt/users
php artisan laravilt:users:install
```

| Command | Description |
|---------|-------------|
| `laravilt:users:install {--force} {--with-permissions}` | Publish files, run migrations, and optionally set up permissions |
| `laravilt:secure` | Generate permissions and roles (`--fresh`, `--super-admin`, `--assign-super-admin`, and more) |
| `laravilt:debug-permissions {user?}` | Inspect a user's permissions |

## Registration

```php
use Laravilt\Users\UsersPlugin;

$panel->plugins([
    UsersPlugin::make()
        ->avatar()
        ->impersonation()
        ->navigationGroup('Access')
        ->navigationSort(10),
]);
```

| Method | Description |
|--------|-------------|
| `userResource(bool)` | Register the user resource (default on) |
| `roleResource(bool)` | Register the role resource (default on) |
| `impersonation(bool)` | Enable impersonation (default off) |
| `avatar(bool)` | Enable avatars (default off) |
| `navigationGroup(?string)` | Navigation group |
| `navigationSort(int)` | Navigation sort (default 10) |
| `userModel(string)` | User model class |
| `userResourceClass(Closure)` | Swap the user resource class |
| `roleResourceClass(Closure)` | Swap the role resource class |

## Plugin class (simplified)

```php
namespace Laravilt\Users;

use Laravilt\Panel\Panel;
use Laravilt\Plugins\PluginProvider;

class UsersPlugin extends PluginProvider
{
    protected static string $id = 'users';

    protected static string $name = 'Users & Roles';

    protected bool $impersonation = false;

    public function impersonation(bool $condition = true): static
    {
        $this->impersonation = $condition;

        return $this;
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            $this->getUserResourceClass(),
            $this->getRoleResourceClass(),
        ]);
    }

    public function boot(Panel $panel): void
    {
        config()->set('laravilt-users.features.impersonation', $this->impersonation);
    }
}
```

## User model traits

```php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravilt\Users\Concerns\HasAvatar;
use Laravilt\Users\Concerns\HasRolesAndPermissions;

class User extends Authenticatable
{
    use HasAvatar;
    use HasRolesAndPermissions;
}
```

Try it on the live demo at [demo.laravilt.com](https://demo.laravilt.com) (login `admin@laravilt.com` / `password`).

## Related

- [Creating a plugin](../tutorials/creating-a-plugin.md)
- [Plugin traits](../concepts/traits.md)
