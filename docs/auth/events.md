---
title: Events
description: Events dispatched by the auth package and how to listen to them.
order: 7
---

# Auth Events

All events live in the `Laravilt\Auth\Events` namespace and expose their data as public properties. Every event includes the `panelId`.

## Login and registration

| Event | Properties |
|-------|------------|
| `LoginAttempt` | `email`, `panelId`, `ipAddress`, `userAgent` |
| `LoginFailed` | `email`, `panelId`, `reason`, `ipAddress`, `userAgent` |
| `LoginSuccessful` | `user`, `panelId`, `remember`, `ipAddress`, `userAgent` |
| `RegistrationAttempt` | `data`, `panelId`, `ipAddress`, `userAgent` |
| `RegistrationCompleted` | `user`, `panelId`, `requiresOtpVerification`, `ipAddress`, `userAgent` |
| `PasswordResetRequested` | `email`, `panelId` |
| `PasswordReset` | `user`, `panelId` |

## OTP and magic links

| Event | Properties |
|-------|------------|
| `OtpSent` | `user`, `code`, `purpose`, `expiresAt`, `panelId` |
| `OtpVerified` | `user`, `purpose`, `panelId` |
| `OtpFailed` | `identifier`, `purpose`, `reason`, `panelId` |
| `MagicLinkSent` | `user`, `url`, `expiresAt`, `panelId` |
| `MagicLinkVerified` | `user`, `panelId` |

## Two-factor

| Event | Properties |
|-------|------------|
| `TwoFactorEnabled` | `user`, `method`, `panelId` |
| `TwoFactorDisabled` | `user`, `panelId` |
| `TwoFactorChallengeSuccessful` | `user`, `method`, `panelId` |
| `TwoFactorChallengeFailed` | `user`, `method`, `panelId` |

## Social login and passkeys

| Event | Properties |
|-------|------------|
| `SocialAuthenticationAttempt` | `provider`, `panelId` |
| `SocialAuthenticationSuccessful` | `user`, `provider`, `providerId`, `isNewUser`, `panelId` |
| `PasskeyRegistered` | `user`, `credentialId`, `name`, `panelId` |
| `PasskeyDeleted` | `user`, `credentialId`, `panelId` |

## Listening to events

```php
<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Laravilt\Auth\Events\LoginSuccessful;

class LogSuccessfulLogin
{
    public function handle(LoginSuccessful $event): void
    {
        Log::info('User logged in', [
            'user_id' => $event->user->id,
            'panel' => $event->panelId,
            'ip' => $event->ipAddress,
        ]);
    }
}
```

Laravel 13 discovers listeners in `app/Listeners` automatically, so no manual registration is needed.

## Built-in notifications

The package sends these notifications from the `Laravilt\Auth\Notifications` namespace: `VerifyEmail`, `ResetPassword`, `OTPNotification`, `TwoFactorCode` and `LoginNotification`.

## Related

- [Routes](routes.md)
- [Configuration](configuration.md)
