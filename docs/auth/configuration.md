---
title: Configuration
description: Enable auth features on a panel and configure the laravilt-auth config file.
order: 1
---

# Auth Configuration

You enable authentication features **per panel** with methods on the `Panel` object. The config file holds package-wide defaults.

## Panel methods

Every page-based method accepts an optional custom page class and URL path, for example `login(?string $page = null, ?string $path = null)`.

| Method | Default path | What it enables |
|--------|--------------|-----------------|
| `login()` | `login` | Login page and `logout` route |
| `registration()` | `register` | Registration page |
| `passwordReset()` | `forgot-password` | Forgot password and `reset-password/{token}` pages |
| `emailVerification()` | `verify-email` | Email verification notice and signed verify link |
| `otp()` | `otp` | One-time code verification page |
| `magicLinks()` | `magic-link` | Passwordless login by emailed link |
| `twoFactor(?string $page, ?string $path, ?callable $builder)` | `profile/two-factor` | Two-factor authentication (see [Two-Factor](methods/two-factor.md)) |
| `socialLogin(Closure\|array $config)` | `auth/{provider}/...` | OAuth login (see [Social Login](methods/social-auth.md)) |
| `passkeys()` | `profile/passkeys` | Passkey management and passkey login |
| `profile()` | `profile` | Profile page |
| `sessionManagement()` | `profile/sessions` | Active sessions page |
| `apiTokens()` | `profile/api-tokens` | Sanctum API token page |
| `connectedAccounts()` | `profile/connected-accounts` | Link or unlink social accounts |
| `localeTimezone()` | `settings/locale-timezone` | Language and timezone preferences |

Related panel methods:

- `disableTwoFactor()` and `disableSocialLogin()` switch those features off again.
- `requirePasswordForSocialLogin(bool $require = true)` sends users who signed up through a social provider to a set-password page until they choose a password. It is on by default.

### Custom pages and paths

```php
use App\Laravilt\Admin\Pages\Auth\Login;

$panel
    ->login(Login::class)               // your own page class
    ->registration(path: 'sign-up');    // default page, custom path
```

A custom page class should extend the matching class in `Laravilt\Auth\Pages`, for example `Laravilt\Auth\Pages\Login`.

## Config file

Publish `config/laravilt-auth.php` to change the defaults:

```bash
php artisan vendor:publish --tag=laravilt-auth-config
```

```php
return [
    'guard' => 'web',

    'methods' => [
        'email' => true,
        'phone' => false,
        'social' => false,
        'passwordless' => false,
        'webauthn' => false,
    ],

    'social' => [
        'providers' => [
            'google' => [
                'client_id' => env('GOOGLE_CLIENT_ID'),
                'client_secret' => env('GOOGLE_CLIENT_SECRET'),
                'redirect' => env('GOOGLE_REDIRECT_URI'),
            ],
            // github, facebook, twitter, linkedin, discord, jira ...
        ],
    ],

    'two_factor' => [
        'enabled' => false,
        'methods' => ['totp', 'sms', 'email'],
        'issuer' => env('APP_NAME', 'Laravilt'),
    ],

    'otp' => [
        'length' => 6,
        'expiry' => 5, // minutes
    ],

    'features' => [
        'registration' => true,
        'email_verification' => true,
        'password_reset' => true,
        'profile' => true,
        'sessions' => true,
        'api_tokens' => true,
    ],

    'routes' => [
        'prefix' => 'auth',
        'middleware' => ['web'],
    ],

    'views' => [
        'theme' => 'default',
        'rtl' => false,
    ],
];
```

Panel methods decide which features a panel actually shows. Configure the panel first and use the config file for shared defaults.

## Publish tags

| Tag | Publishes |
|-----|-----------|
| `laravilt-auth-config` | `config/laravilt-auth.php` |
| `laravilt-auth-migrations` | Migrations (they also load automatically without publishing) |
| `laravilt-auth-views` | Frontend pages for your stack (Vue or React) to `resources/js/pages/laravilt/auth` |
| `laravilt-auth-blade-views` | Blade views, such as mail templates |
| `laravilt-auth-assets` | Compiled assets |

> React support requires Laravilt v1.1 or later.

## Artisan commands

```bash
# Install the auth package
php artisan laravilt:auth:install [--force]
php artisan auth:install [--force] [--without-assets] [--without-migrations] [--without-seeders]

# Interactively generate an auth provider configuration for a custom guard or model
php artisan laravilt:auth:generate {name?} [--guard=] [--model=] [--methods=*] [--output=] [--add-to-config]

# Create a panel user
php artisan laravilt:user --name="Admin" --email=admin@example.com --password=secret
```

## Related

- [User Model](user-model.md)
- [Migrations](migrations.md)
- [Panel](../panel/README.md)
