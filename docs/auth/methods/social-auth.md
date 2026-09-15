---
title: Social Login
description: OAuth login with Google, GitHub, Facebook, Twitter, LinkedIn, Discord and Jira.
order: 2
---

# Social Login

Social login uses Laravel Socialite. You register providers with a `SocialProviderBuilder`, and a button for each enabled provider appears on the login page.

## Enable in the panel

```php
use Laravilt\Auth\Builders\SocialProviderBuilder;
use Laravilt\Auth\Drivers\SocialProviders\GitHubProvider;
use Laravilt\Auth\Drivers\SocialProviders\GoogleProvider;

public function panel(Panel $panel): Panel
{
    return $panel
        ->id('admin')
        ->path('admin')
        ->login()
        ->socialLogin(function (SocialProviderBuilder $builder) {
            $builder
                ->provider(GoogleProvider::class, fn (GoogleProvider $p) => $p->enabled())
                ->provider(GitHubProvider::class, fn (GitHubProvider $p) => $p->enabled());
        });
}
```

`socialLogin()` also accepts a plain array of provider names:

```php
$panel->socialLogin(['google', 'github']);
```

## Available providers

All providers live in `Laravilt\Auth\Drivers\SocialProviders`:

| Class | Name |
|-------|------|
| `GoogleProvider` | `google` |
| `GitHubProvider` | `github` |
| `FacebookProvider` | `facebook` |
| `TwitterProvider` | `twitter` |
| `LinkedInProvider` | `linkedin` |
| `DiscordProvider` | `discord` |
| `JiraProvider` | `jira` |

## Credentials

Providers read their credentials from `config/services.php`, as Socialite does:

```php
// config/services.php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URI'),
],

'github' => [
    'client_id' => env('GITHUB_CLIENT_ID'),
    'client_secret' => env('GITHUB_CLIENT_SECRET'),
    'redirect' => env('GITHUB_REDIRECT_URI'),
],
```

```env
GOOGLE_CLIENT_ID=...
GOOGLE_CLIENT_SECRET=...
GOOGLE_REDIRECT_URI="${APP_URL}/admin/auth/google/callback"
```

The callback URL is `/{panel}/auth/{provider}/callback`, and the redirect route is `/{panel}/auth/{provider}/redirect`.

If you don't call `enabled()`, a provider is shown only when both `client_id` and `client_secret` are set in `config/services.php`.

## Customizing a provider

The second argument of `provider()` receives the provider instance:

```php
$builder->provider(GoogleProvider::class, fn (GoogleProvider $p) => $p
    ->label('Continue with Google')
    ->colorClasses('bg-white text-gray-900 border')
    ->enabled(),
);
```

| Method | Description |
|--------|-------------|
| `enabled(bool $enabled = true)` / `disabled()` | Force the provider on or off |
| `label(string $label)` | Button label |
| `icon(string $icon)` | Button icon (an SVG path string) |
| `colorClasses(string $classes)` | Tailwind classes for the button |
| `socialiteDriver(string $driver)` | Socialite driver name to use |
| `redirectUrl(string $url)` / `callbackUrl(string $url)` | Override the URLs |

## Passwords for social users

Social sign-ups have no password. By default, `requirePasswordForSocialLogin()` is on, and those users are sent to a set-password page after logging in. Turn it off with `$panel->requirePasswordForSocialLogin(false)`.

## Connected accounts

Add `->connectedAccounts()` so users can link or unlink providers from their settings. Linked accounts are stored in `social_accounts`. See [Connected Accounts](../profile/connected-accounts.md).

## Events

`SocialAuthenticationAttempt` and `SocialAuthenticationSuccessful` (includes `isNewUser`). See [Events](../events.md).
