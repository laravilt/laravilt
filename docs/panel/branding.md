---
title: Branding & Theming
description: Customize your panel's name, logo, colors, font, dark mode and styles.
order: 4
---

# Branding & Theming

Customize the look and feel of your panel.

## Brand Name & Logo

```php
public function panel(Panel $panel): Panel
{
    return $panel
        ->brandName('My Admin Panel')
        ->brandLogo('/images/logo.svg')
        ->brandLogoHeight('2rem')
        ->favicon('/favicon.ico');
}
```

All four methods also accept a closure.

## Colors

```php
return $panel->colors([
    'primary' => '#3b82f6',
    'secondary' => '#64748b',
    'success' => '#22c55e',
    'warning' => '#f59e0b',
    'danger' => '#ef4444',
    'info' => '#06b6d4',
]);
```

### Using the Color Palette

`Laravilt\Support\Colors\Color` has hex constants for the Tailwind palette (`Slate`, `Gray`, `Zinc`, `Neutral`, `Stone`, `Red`, `Orange`, `Amber`, `Yellow`, `Lime`, `Green`, `Emerald`, `Teal`, `Cyan`, `Sky`, `Blue`, `Indigo`, `Violet`, `Purple`, `Fuchsia`, `Pink`, `Rose`). It also has semantic constants (`Primary`, `Secondary`, `Success`, `Danger`, `Warning`, `Info`):

```php
use Laravilt\Support\Colors\Color;

return $panel->colors([
    'primary' => Color::Blue,
    'secondary' => Color::Slate,
    'success' => Color::Green,
]);
```

## Typography

Pass a font family name, which loads from Google Fonts, or a configured `GoogleFontProvider`:

```php
use Laravilt\Panel\FontProviders\GoogleFontProvider;

// Simple
$panel->font('Inter');

// With options
$panel->font(
    GoogleFontProvider::make('Inter')
        ->weights([400, 500, 600, 700])
        ->subsets(['latin'])
        ->display('swap')
);
```

## Dark Mode

Dark mode (with the appearance toggle) is enabled by default. To disable it:

```php
$panel->darkMode(false);
```

## Custom CSS and JavaScript

Panels use your application's Vite build with Tailwind CSS v4. The simplest way to add styles is to edit `resources/css/app.css`, and to add scripts through your app entry point: `resources/js/app.ts` (Vue) or `resources/js/app.tsx` (React).

```css
/* resources/css/app.css */
@theme {
    --font-sans: 'Inter', ui-sans-serif, system-ui, sans-serif;
}

.sidebar-banner {
    @apply rounded-md bg-primary/10 px-3 py-2 text-sm;
}
```

The panel also exposes `customCss()` and `customJs()` to register extra files on the panel object:

```php
$panel
    ->customCss(['css/admin-theme.css'])
    ->customJs(['js/admin.js']);
```

> React support requires Laravilt v1.1 or later.

## Reusable Theme Presets

To share a look across panels, put the branding calls in a plain PHP class:

```php
namespace App\Laravilt\Themes;

use Laravilt\Panel\Panel;
use Laravilt\Support\Colors\Color;

class OceanTheme
{
    public static function apply(Panel $panel): Panel
    {
        return $panel
            ->colors([
                'primary' => Color::Sky,
                'secondary' => Color::Slate,
            ])
            ->font('Inter');
    }
}
```

```php
use App\Laravilt\Themes\OceanTheme;

public function panel(Panel $panel): Panel
{
    return OceanTheme::apply($panel)
        ->id('admin')
        ->path('admin');
}
```

## Next Steps

- [Layout & Localization](layout.md): layout, locale and RTL
- [Panel Authentication](panel-auth.md): auth features
