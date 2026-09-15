---
title: Passkeys
description: Passwordless WebAuthn login with fingerprint, Face ID or hardware security keys.
order: 4
---

# Passkeys (WebAuthn)

Passkeys let users sign in with a fingerprint, Face ID, Windows Hello or a hardware security key instead of a password. Laravilt uses `laragear/webauthn`, which is installed with the auth package.

## Enable in the panel

```php
public function panel(Panel $panel): Panel
{
    return $panel
        ->id('admin')
        ->path('admin')
        ->login()
        ->passkeys();
}
```

`passkeys(?string $page = null, ?string $path = null)` does two things:

- It adds a **Passkeys** settings page (`Laravilt\Auth\Pages\Profile\ManagePasskeys`) where users register, name and delete passkeys.
- It enables a "Sign in with passkey" option on the login page, backed by `GET /{panel}/passkey/login-options` and `POST /{panel}/passkey/login`.

## Requirements

- HTTPS (browsers allow plain HTTP only on `localhost`)
- A browser with WebAuthn support (all current browsers)
- The `webauthn_credentials` table, which is created by the auth migrations

## Working with passkeys in code

```php
$user->hasPasskeys();          // bool
$user->passkeys()->get();      // WebauthnCredential models (alias: webauthnCredentials())
```

Credentials are stored in `webauthn_credentials` and belong to the user through a polymorphic `authenticatable` relation. Private keys never leave the user's device. Only the public key is stored.

## Events

`PasskeyRegistered` and `PasskeyDeleted`. See [Events](../events.md).

## Related

- [Two-Factor Authentication](two-factor.md)
- [Profile & Settings](../profile/README.md)
