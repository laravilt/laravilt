---
title: Locale & Timezone
description: Let users choose their language and timezone.
order: 6
---

# Locale & Timezone

`->localeTimezone()` adds a **Locale & timezone** page (`Laravilt\Auth\Pages\LocaleTimezone`) to the Settings cluster, at `/{panel}/settings/locale-timezone`.

```php
$panel->localeTimezone();
```

The page saves two columns on `users`, which the auth migrations add:

| Field | Rules |
|-------|-------|
| `locale` | `required`, `string`, `max:10` |
| `timezone` | `required`, a valid timezone identifier |

## Available languages

The language list comes from `config('app.available_locales')`, which defaults to English and Arabic. Define your own in `config/app.php`:

```php
'available_locales' => [
    ['value' => 'en', 'label' => 'English', 'dir' => 'ltr'],
    ['value' => 'ar', 'label' => 'العربية', 'dir' => 'rtl'],
    ['value' => 'fr', 'label' => 'Français', 'dir' => 'ltr'],
],
```

`dir` tells the panel whether to use a right-to-left layout for that language.

## Quick switching

Every panel also exposes `POST /{panel}/locale` for a quick language switcher.

## In code

```php
$user->getPreferredLocale();   // saved locale or config('app.locale')
$user->getPreferredTimezone(); // saved timezone or config('app.timezone')

$user->setLocale('ar');
$user->setTimezone('Africa/Cairo');
```

## Related

- [Profile Information](profile-info.md)
- [User Model](../user-model.md)
