---
title: Connected Accounts
description: Let users link and unlink social login providers.
order: 5
---

# Connected Accounts

`->connectedAccounts()` adds a **Connected accounts** page (`Laravilt\Auth\Pages\Profile\ConnectedAccounts`). It lists every enabled social provider, shows which ones the user has linked (with the linked name, email and avatar), and lets the user connect or disconnect them.

```php
use Laravilt\Auth\Builders\SocialProviderBuilder;
use Laravilt\Auth\Drivers\SocialProviders\GitHubProvider;
use Laravilt\Auth\Drivers\SocialProviders\GoogleProvider;

$panel
    ->connectedAccounts()
    ->socialLogin(function (SocialProviderBuilder $builder) {
        $builder
            ->provider(GoogleProvider::class)
            ->provider(GitHubProvider::class);
    });
```

The page only shows providers you registered with `socialLogin()`. See [Social Login](../methods/social-auth.md) for credentials.

## Routes

```
GET     /{panel}/profile/connected-accounts             List providers
DELETE  /{panel}/profile/connected-accounts/{provider}  Disconnect a provider
```

Connecting goes through the normal `/{panel}/auth/{provider}/redirect` flow.

## In code

Linked accounts are `Laravilt\Auth\Models\SocialAccount` rows in `social_accounts`:

```php
$user->socialAccounts;                 // or $user->connectedAccounts
$user->hasSocialAccount('github');     // bool
$user->getSocialAccount('github');     // ?SocialAccount
```

## Related

- [Social Login](../methods/social-auth.md)
- [Locale & Timezone](preferences.md)
