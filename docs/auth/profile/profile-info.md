---
title: Profile Information
description: Let users update their name and email address.
order: 1
---

# Profile Information

`->profile()` adds the **Profile** page (`Laravilt\Auth\Pages\Profile`) to the Settings cluster at `/{panel}/settings/profile`. `/{panel}/profile` redirects there.

```php
$panel->profile();

// Custom page class or path
$panel->profile(\App\Laravilt\Admin\Pages\Profile::class, 'account');
```

The page validates and saves:

| Field | Rules |
|-------|-------|
| `name` | `required`, `string`, `max:255` |
| `email` | `required`, `email`, `max:255`, unique in `users` (ignoring the current user) |

## Customizing

Extend the page and pass your class to `profile()`:

```php
<?php

namespace App\Laravilt\Admin\Pages;

use Laravilt\Auth\Pages\Profile as BaseProfile;

class Profile extends BaseProfile
{
    public function getSubheading(): ?string
    {
        return 'Keep your contact details up to date.';
    }
}
```

For avatar uploads, the `laravilt/users` package provides a `HasAvatar` trait. When it's present, `LaraviltUser` uses it for avatar URLs.

## Related

- [Password](password.md)
- [Locale & Timezone](preferences.md)
