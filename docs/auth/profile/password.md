---
title: Password
description: Let users change their password from the Settings cluster.
order: 2
---

# Change Password

With `->profile()` enabled, the Settings cluster also contains a **Change password** page (`Laravilt\Auth\Pages\Profile\ChangePassword`, slug `change-password`).

The form has three fields:

| Field | Purpose |
|-------|---------|
| `current_password` | Must match the user's current password |
| `password` | The new password, validated with `Password::defaults()` |
| `password_confirmation` | Must match `password` |

## Password rules

The page uses Laravel's default password rule, so you configure it in one place (usually `AppServiceProvider::boot()`):

```php
use Illuminate\Validation\Rules\Password;

Password::defaults(function () {
    return Password::min(12)
        ->mixedCase()
        ->numbers()
        ->uncompromised();
});
```

The same rule applies to registration and password reset.

## Users without a password

Users created through social login or magic links have a `null` password. When `requirePasswordForSocialLogin()` is on (the default), they are sent to `/{panel}/set-password` to choose one.

## Related

- [Profile Information](profile-info.md)
- [Sessions](sessions.md)
