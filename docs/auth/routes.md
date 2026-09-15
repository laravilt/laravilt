---
title: Routes
description: Routes registered by each auth feature, relative to the panel path.
order: 6
---

# Auth Routes

Routes are registered only for the features you enable, and each one is prefixed with the panel path (for example `/admin`). The paths below are the defaults. You can change most of them with the `$path` argument of the panel method.

## Guest routes

```
GET|POST  login                      Login                  ->login()
GET|POST  register                   Registration           ->registration()
GET|POST  forgot-password            Request reset link     ->passwordReset()
GET       reset-password/{token}     Reset form
POST      reset-password             Reset password
GET|POST  otp                        Verify one-time code   ->otp()
POST      otp/resend                 Resend code
GET|POST  magic-link                 Request magic link     ->magicLinks()
GET       magic-link/verify/{token}  Log in via link
GET       auth/{provider}/redirect   Redirect to provider   ->socialLogin()
GET       auth/{provider}/callback   Provider callback
GET|POST  two-factor/challenge       2FA challenge          ->twoFactor()
POST      two-factor/resend          Resend email code
GET|POST  two-factor/recovery        Use a recovery code
GET       passkey/login-options      Passkey options        ->passkeys()
POST      passkey/login              Log in with passkey
```

## Authenticated routes

```
POST        logout                                 Logout
POST        locale                                 Quick locale switch
GET         verify-email                           Verification notice
GET         email/verify/{id}/{hash}               Verify email (signed)
POST        email/verification-notification        Resend verification email
GET|PATCH   profile                                Profile page
PUT         password                               Change password
GET         profile/two-factor/status              2FA status
POST        profile/two-factor/enable              Start 2FA setup
POST        profile/two-factor/confirm             Confirm 2FA
DELETE      profile/two-factor/disable             Disable 2FA
POST        profile/two-factor/recovery-codes      Regenerate recovery codes
GET         profile/sessions                       Sessions
DELETE      profile/sessions/{sessionId}           Log out a session
DELETE      profile/sessions/others                Log out other sessions
GET|POST    profile/api-tokens                     API tokens
PUT|DELETE  profile/api-tokens/{tokenId}           Update or delete a token
GET         profile/passkeys/register-options      Passkey registration options
POST        profile/passkeys/register              Register a passkey
DELETE      profile/passkeys/{credentialId}        Delete a passkey
GET         profile/connected-accounts             Connected accounts
DELETE      profile/connected-accounts/{provider}  Disconnect a provider
```

The profile pages belong to the `Settings` cluster (slug `settings`), so they are served under `/{panel}/settings/...`, for example `/admin/settings/profile` and `/admin/settings/two-factor`. `/{panel}/profile` redirects there.

Run `php artisan route:list --path=admin` to see the exact routes and route names for your panel.

## Related

- [Configuration](configuration.md)
- [Events](events.md)
