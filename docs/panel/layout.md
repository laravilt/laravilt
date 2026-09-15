---
title: Layout & Localization
description: Configure content width, page layouts, locale, timezone and RTL support.
order: 5
---

# Layout & Localization

## Max Content Width

```php
// Tailwind max-width sizes: sm, md, lg, xl, 2xl ... 7xl, full
$panel->maxContentWidth('7xl');   // Default
$panel->maxContentWidth('full');  // Full width
```

The default comes from `max_content_width` in the panel config.

## Page Layouts

Each page chooses a layout by overriding `getLayout()`. The available values are in `Laravilt\Panel\Enums\PageLayout`: `Panel` (the default), `Card`, `Simple`, `Full` and `Settings`.

```php
use Laravilt\Panel\Enums\PageLayout;
use Laravilt\Panel\Pages\Page;

class Preferences extends Page
{
    public function getLayout(): string
    {
        return PageLayout::Settings->value;
    }
}
```

## Locale & Timezone

The panel's localization middleware applies each request's locale and timezone:

1. the authenticated user's `locale` and `timezone` columns, if present
2. otherwise `config('app.locale')` and `config('app.timezone')`

To let users pick their own language and timezone from their profile, enable the locale/timezone page:

```php
$panel->localeTimezone();
```

## RTL Support

RTL layout is switched on automatically when the active locale is right-to-left: Arabic (`ar`), Hebrew (`he`), Persian (`fa`), Urdu (`ur`), Pashto (`ps`), Sindhi (`sd`), Yiddish (`yi`), Uyghur (`ug`) or Divehi (`dv`). Regional variants such as `ar_EG` count too. The direction is shared with the frontend as `localization.direction` and `localization.isRtl`.

## Next Steps

- [Branding & Theming](branding.md): colors and fonts
- [Panel Authentication](panel-auth.md): auth features
