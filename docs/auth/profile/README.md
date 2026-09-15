---
title: Profile & Settings
description: The built-in account pages users get in the Settings cluster.
order: 5
---

# Profile & Settings

When you enable account features on a panel, Laravilt adds ready-made pages to a **Settings** cluster (`Laravilt\Auth\Clusters\Settings`, slug `settings`). Users reach them from the user menu, for example at `/admin/settings/profile`.

```php
public function panel(Panel $panel): Panel
{
    return $panel
        ->id('admin')
        ->path('admin')
        ->login()
        ->profile()
        ->twoFactor()
        ->passkeys()
        ->connectedAccounts()
        ->sessionManagement()
        ->apiTokens()
        ->localeTimezone();
}
```

| Panel method | Page class | Settings page |
|--------------|------------|---------------|
| `profile()` | `Laravilt\Auth\Pages\Profile` | Profile |
| `profile()` | `Laravilt\Auth\Pages\Profile\ChangePassword` | Change password |
| `twoFactor()` | `Laravilt\Auth\Pages\Profile\ManageTwoFactor` | Two-factor |
| `passkeys()` | `Laravilt\Auth\Pages\Profile\ManagePasskeys` | Passkeys |
| `sessionManagement()` | `Laravilt\Auth\Pages\Profile\ManageSessions` | Sessions |
| `apiTokens()` | `Laravilt\Auth\Pages\Profile\ManageApiTokens` | API tokens |
| `connectedAccounts()` | `Laravilt\Auth\Pages\Profile\ConnectedAccounts` | Connected accounts |
| `localeTimezone()` | `Laravilt\Auth\Pages\LocaleTimezone` | Locale & timezone |

Each method accepts `?string $page = null, ?string $path = null`, so you can swap in your own page class (extend the original) or change its path.

## Pages

1. [Profile Information](profile-info.md)
2. [Password](password.md)
3. [Sessions](sessions.md)
4. [API Tokens](api-tokens.md)
5. [Connected Accounts](connected-accounts.md)
6. [Locale & Timezone](preferences.md)

Two-factor and passkey management are covered in [Two-Factor Authentication](../methods/two-factor.md) and [Passkeys](../methods/passkeys.md).
