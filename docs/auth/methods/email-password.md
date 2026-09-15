---
title: Email & Password
description: Login, registration, password reset, email verification, OTP and magic links.
order: 1
---

# Email & Password Authentication

These are the classic sign-in flows, plus two passwordless options (one-time codes and magic links).

## Enable in the panel

```php
public function panel(Panel $panel): Panel
{
    return $panel
        ->id('admin')
        ->path('admin')
        ->login()
        ->registration()
        ->passwordReset()
        ->emailVerification()
        ->otp()
        ->magicLinks();
}
```

| Method | Default path | Page class |
|--------|--------------|------------|
| `login()` | `/admin/login` | `Laravilt\Auth\Pages\Login` |
| `registration()` | `/admin/register` | `Laravilt\Auth\Pages\Register` |
| `passwordReset()` | `/admin/forgot-password`, `/admin/reset-password/{token}` | `ForgotPassword`, `ResetPassword` |
| `emailVerification()` | `/admin/verify-email` | `EmailVerification` |
| `otp()` | `/admin/otp` | `OTP` |
| `magicLinks()` | `/admin/magic-link` | `MagicLink` |

Every method accepts `?string $page = null, ?string $path = null`:

```php
$panel
    ->login(path: 'sign-in')
    ->registration(\App\Laravilt\Admin\Pages\Auth\Register::class);
```

A custom page should extend the package page it replaces.

## Password reset and email verification

Both flows use Laravel's password broker and signed URLs, so make sure mail is configured (`MAIL_MAILER` and related settings). The verification link is `/{panel}/email/verify/{id}/{hash}`, which is signed and throttled to 6 requests per minute.

Password rules follow Laravel's `Password::defaults()`. Set your own rules in a service provider:

```php
use Illuminate\Validation\Rules\Password;

Password::defaults(fn () => Password::min(12)->mixedCase()->numbers());
```

## One-time codes (OTP)

`otp()` adds a code-entry page used to verify a user by a 6-digit code sent to them, for example after registration. Codes are stored in the `otp_codes` table. The length and expiry come from `config/laravilt-auth.php`:

```php
'otp' => [
    'length' => 6,
    'expiry' => 5, // minutes
],
```

The flow dispatches `OtpSent`, `OtpVerified` and `OtpFailed`.

## Magic links

`magicLinks()` adds a "Email me a login link" page. The user receives a link to `/{panel}/magic-link/verify/{token}` and is logged in when they open it. The flow dispatches `MagicLinkSent` and `MagicLinkVerified`.

## Events

`LoginAttempt`, `LoginFailed`, `LoginSuccessful`, `RegistrationAttempt`, `RegistrationCompleted`, `PasswordResetRequested` and `PasswordReset`. See [Events](../events.md).

## Related

- [Two-Factor Authentication](two-factor.md)
- [Configuration](../configuration.md)
