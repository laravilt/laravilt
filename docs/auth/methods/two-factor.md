---
title: Two-Factor Authentication
description: Authenticator app (TOTP) and email code second factors with recovery codes.
order: 3
---

# Two-Factor Authentication

Two-factor authentication (2FA) adds a second step after login. Users turn it on from their settings, choosing an authenticator app (TOTP) or email codes.

## Enable in the panel

```php
use Laravilt\Auth\Builders\TwoFactorProviderBuilder;
use Laravilt\Auth\Drivers\EmailDriver;
use Laravilt\Auth\Drivers\TotpDriver;

public function panel(Panel $panel): Panel
{
    return $panel
        ->id('admin')
        ->path('admin')
        ->login()
        ->twoFactor(builder: function (TwoFactorProviderBuilder $builder) {
            $builder
                ->provider(TotpDriver::class)
                ->provider(EmailDriver::class);
        });
}
```

Calling `->twoFactor()` with no builder registers both `TotpDriver` and `EmailDriver`. The signature is `twoFactor(?string $page = null, ?string $path = null, ?callable $builder = null)`, so pass the builder as a named argument.

## Drivers

| Driver | Name | How it works |
|--------|------|--------------|
| `Laravilt\Auth\Drivers\TotpDriver` | `totp` | Shows a QR code for Google Authenticator, 1Password, Authy and similar apps. Requires confirmation with a first code. |
| `Laravilt\Auth\Drivers\EmailDriver` | `email` | Emails a one-time code at each login. |

### Custom drivers

Implement `Laravilt\Auth\Contracts\TwoFactorDriver` (`getName()`, `getLabel()`, `getIcon()`, `enable()`, `verify()`, `send()`, `requiresSending()`, `requiresConfirmation()`) and register it:

```php
$builder->provider(SmsDriver::class, function (SmsDriver $driver) {
    // optional configuration of the driver instance
});
```

`provider()` accepts a class name (resolved from the container) or an instance.

## User flow

1. The user opens **Settings > Two-Factor** (`/admin/settings/two-factor`), picks a method and confirms it.
2. Recovery codes are generated when 2FA is confirmed. They can be regenerated from the same page.
3. At the next login, the user is redirected to `/admin/two-factor/challenge`. A lost device can be bypassed at `/admin/two-factor/recovery` with a recovery code.

Secrets and recovery codes are stored on the `users` table (`two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `two_factor_method`, `two_factor_enabled`). The `LaraviltUser` trait includes Fortify's `TwoFactorAuthenticatable`, so Fortify helpers such as `$user->recoveryCodes()` are available. Use `$user->hasTwoFactorEnabled()` to check the status.

## Events

`TwoFactorEnabled`, `TwoFactorDisabled`, `TwoFactorChallengeSuccessful` and `TwoFactorChallengeFailed`. See [Events](../events.md).

## Related

- [Passkeys](passkeys.md)
- [User Model](../user-model.md)
