---
title: Migrations
description: Tables and columns created by the auth package.
order: 3
---

# Auth Migrations

The package loads its migrations automatically, so running migrations is enough:

```bash
php artisan migrate
```

To customize them, publish them first:

```bash
php artisan vendor:publish --tag=laravilt-auth-migrations
```

## Tables

| Table | Purpose |
|-------|---------|
| `social_accounts` | Linked OAuth accounts (`provider`, `provider_id`, `name`, `email`, `avatar`, `token`, `refresh_token`, `expires_at`) |
| `webauthn_credentials` | Passkeys, using the `laragear/webauthn` schema (polymorphic `authenticatable`, `alias`, `public_key`, `counter`, `transports`, and more) |
| `two_factor_codes` | Short-lived two-factor codes |
| `otp_codes` | One-time codes (`identifier`, `code`, `purpose`, `expires_at`, `verified`) |
| `personal_access_tokens` | Sanctum tokens (skipped if the table already exists) |

## Changes to `users`

| Column | Type |
|--------|------|
| `two_factor_enabled` | boolean, default `false` |
| `two_factor_method` | string, nullable |
| `two_factor_secret` | text, nullable |
| `two_factor_recovery_codes` | text, nullable |
| `two_factor_confirmed_at` | timestamp, nullable |
| `locale` | string(10), nullable |
| `timezone` | string(50), nullable |

`password` also becomes nullable so users who sign up with social login or a magic link can exist without a password.

## Related

- [User Model](user-model.md)
- [Configuration](configuration.md)
