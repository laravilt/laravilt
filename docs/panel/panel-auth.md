---
title: Panel Authentication
description: Enable login, registration, two-factor, social login, passkeys and other auth features per panel.
order: 6
---

# Panel Authentication

Each panel turns on the auth features it needs. Every feature method accepts optional `page` and `path` arguments, so you can swap in a custom page class or URL. Each also has a `disable*()` counterpart. For details on each feature, see the [Auth](../auth/README.md) section.

## Basic Authentication

```php
public function panel(Panel $panel): Panel
{
    return $panel
        ->login()
        ->registration()
        ->passwordReset()
        ->emailVerification()
        ->profile();
}
```

## One-Time Passwords & Magic Links

```php
return $panel
    ->otp()
    ->magicLinks();
```

## Two-Factor Authentication

```php
use Laravilt\Auth\Builders\TwoFactorProviderBuilder;
use Laravilt\Auth\Drivers\EmailDriver;
use Laravilt\Auth\Drivers\TotpDriver;

return $panel->twoFactor(builder: function (TwoFactorProviderBuilder $builder) {
    $builder->provider(TotpDriver::class);
    $builder->provider(EmailDriver::class);
});
```

## Social Login

```php
use Laravilt\Auth\Builders\SocialProviderBuilder;
use Laravilt\Auth\Drivers\SocialProviders\GitHubProvider;
use Laravilt\Auth\Drivers\SocialProviders\GoogleProvider;

return $panel
    ->socialLogin(function (SocialProviderBuilder $builder) {
        $builder->provider(GoogleProvider::class, fn (GoogleProvider $p) => $p->enabled());
        $builder->provider(GitHubProvider::class, fn (GitHubProvider $p) => $p->enabled());
    })
    ->requirePasswordForSocialLogin();
```

Available providers: `GoogleProvider`, `GitHubProvider`, `FacebookProvider`, `TwitterProvider`, `LinkedInProvider`, `DiscordProvider` and `JiraProvider`.

## Passkeys (WebAuthn)

```php
return $panel->passkeys();
```

## Account Management

```php
return $panel
    ->connectedAccounts()   // Manage linked social accounts
    ->sessionManagement()   // View and revoke browser sessions
    ->apiTokens()           // Personal API tokens
    ->localeTimezone();     // Language and timezone preferences
```

## Complete Example

```php
namespace App\Providers\Laravilt;

use Laravilt\Auth\Builders\SocialProviderBuilder;
use Laravilt\Auth\Builders\TwoFactorProviderBuilder;
use Laravilt\Auth\Drivers\SocialProviders\GitHubProvider;
use Laravilt\Auth\Drivers\TotpDriver;
use Laravilt\Panel\Panel;
use Laravilt\Panel\PanelProvider;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->discoverAutomatically()
            ->login()
            ->registration()
            ->passwordReset()
            ->emailVerification()
            ->profile()
            ->passkeys()
            ->magicLinks()
            ->apiTokens()
            ->sessionManagement()
            ->connectedAccounts()
            ->twoFactor(builder: function (TwoFactorProviderBuilder $builder) {
                $builder->provider(TotpDriver::class);
            })
            ->socialLogin(function (SocialProviderBuilder $builder) {
                $builder->provider(GitHubProvider::class, fn (GitHubProvider $p) => $p->enabled());
            });
    }
}
```

## Next Steps

- [Auth](../auth/README.md): how each auth feature works
- [Multi-Tenancy](tenancy/README.md): tenant-aware panels
