---
title: User Model
description: Add the LaraviltUser trait to your User model to enable every auth feature.
order: 2
---

# User Model Setup

The installer publishes a `User` model that already uses the `LaraviltUser` trait. If you manage the model yourself, add the trait:

```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravilt\Auth\Concerns\LaraviltUser;

class User extends Authenticatable
{
    use LaraviltUser;
    use Notifiable;

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
```

## What the trait adds

`LaraviltUser` includes Sanctum's `HasApiTokens` and Fortify's `TwoFactorAuthenticatable`. When the model initializes, it also merges these attributes for you:

- **Fillable:** `locale`, `timezone`, `two_factor_enabled`, `two_factor_method`
- **Hidden:** `two_factor_secret`, `two_factor_recovery_codes`
- **Casts:** `two_factor_enabled` to `boolean`, `two_factor_confirmed_at` to `datetime`

### Relationships

| Method | Returns |
|--------|---------|
| `socialAccounts()` / `connectedAccounts()` | `HasMany` of `Laravilt\Auth\Models\SocialAccount` |
| `webauthnCredentials()` / `passkeys()` | `MorphMany` of `Laravilt\Auth\Models\WebauthnCredential` |

### Methods

| Method | Description |
|--------|-------------|
| `hasSocialAccount(string $provider)` | Whether a provider is linked |
| `getSocialAccount(string $provider)` | The linked `SocialAccount` or `null` |
| `hasPasskeys()` | Whether the user registered any passkey |
| `sessions()` | Collection of the user's database sessions |
| `otherSessions()` | Sessions other than the current one |
| `deleteOtherSessions()` | Log out other sessions; returns the number removed |
| `hasTwoFactorEnabled()` | Whether 2FA is enabled |
| `hasConfirmedTwoFactor()` | Whether 2FA setup was confirmed |
| `getPreferredLocale()` / `getPreferredTimezone()` | Saved preference, or the app default |
| `setLocale(string $locale)` / `setTimezone(string $timezone)` | Save a preference |
| `getSocialAvatarUrl()` | Avatar from a linked social account |
| `getAvatarUrlFromAuth()` | Avatar URL with fallbacks |

`sessions()`, `otherSessions()` and `deleteOtherSessions()` read the sessions table, so they need `SESSION_DRIVER=database`.

## Related

- [Migrations](migrations.md)
- [Configuration](configuration.md)
