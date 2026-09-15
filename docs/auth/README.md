---
title: Authentication
description: Login, registration, two-factor, passkeys, social login and profile management for Laravilt panels.
order: 10
---

# Authentication

The `laravilt/auth` package gives every panel a complete authentication system. You turn features on with fluent methods on the panel, and the package registers the pages, routes, migrations and events for you.

Features include email and password login, registration, password reset, email verification, one-time codes (OTP), magic links, two-factor authentication (authenticator app or email code), passkeys (WebAuthn), social login, session management, API tokens (Sanctum), connected accounts and locale/timezone preferences.

`php artisan laravilt:install` asks which of these features you want and writes the matching methods into your panel provider (`app/Providers/Laravilt/AdminPanelProvider.php`):

```php
use Laravilt\Auth\Builders\SocialProviderBuilder;
use Laravilt\Auth\Builders\TwoFactorProviderBuilder;
use Laravilt\Auth\Drivers\EmailDriver;
use Laravilt\Auth\Drivers\SocialProviders\GitHubProvider;
use Laravilt\Auth\Drivers\TotpDriver;

return $panel
    ->id('admin')
    ->path('admin')
    ->login()
    ->registration()
    ->passwordReset()
    ->emailVerification()
    ->twoFactor(builder: function (TwoFactorProviderBuilder $builder) {
        $builder->provider(TotpDriver::class);
        $builder->provider(EmailDriver::class);
    })
    ->socialLogin(function (SocialProviderBuilder $builder) {
        $builder->provider(GitHubProvider::class, fn (GitHubProvider $p) => $p->enabled());
    })
    ->profile()
    ->passkeys()
    ->magicLinks()
    ->connectedAccounts()
    ->sessionManagement()
    ->apiTokens()
    ->localeTimezone();
```

Try it on the [live demo](https://demo.laravilt.com) (log in with `admin@laravilt.com` / `password`).

## In this section

1. [Configuration](configuration.md): panel methods, the config file and artisan commands
2. [User Model](user-model.md): the `LaraviltUser` trait
3. [Migrations](migrations.md): the tables and columns the package adds
4. [Authentication Methods](methods/README.md): email and password, social login, two-factor, passkeys
5. [Profile & Settings](profile/README.md): the built-in account pages
6. [Routes](routes.md): every route the package registers
7. [Events](events.md): events you can listen to

## Dependencies

These are installed automatically with `laravilt/auth`:

| Package | Used for |
|---------|----------|
| `laravel/fortify` | Two-factor secrets and recovery codes |
| `laravel/sanctum` | API tokens |
| `laravel/socialite` (plus `socialiteproviders/discord` and `socialiteproviders/atlassian`) | Social login |
| `laragear/webauthn` | Passkeys |
| `jenssegers/agent` | Device details on the sessions page |
