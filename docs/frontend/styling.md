---
title: Styling & Theming
description: Tailwind CSS v4 setup, theme variables, brand colors and dark mode in Laravilt apps.
order: 3
---

# Styling & Theming

Laravilt uses **Tailwind CSS v4** with CSS-first configuration. There is no `tailwind.config.js`: the theme, sources and variants all live in `resources/css/app.css`, which the installer publishes for both stacks.

> React support requires Laravilt v1.1 or later.

## app.css Structure

```css
@import 'tailwindcss';
@import 'tw-animate-css';

/* Scan Laravilt package sources for classes */
@source '../../vendor/laravilt/*/resources/js/**/*.vue';   /* React: resources/react/**/*.tsx */
@source '../../vendor/laravilt/*/resources/js/**/*.ts';

@custom-variant dark (&:is(.dark *));

@theme inline {
    --color-background: var(--background);
    --color-foreground: var(--foreground);
    --color-primary: var(--primary);
    --color-primary-foreground: var(--primary-foreground);
    /* ... card, popover, secondary, muted, accent, destructive, border, input, ring,
       chart-1..5, sidebar-*, brand, brand-accent ... */
    --radius-lg: var(--radius);
}

:root {
    --brand: hsl(3.5 100% 56.3%);           /* #FF2D20 */
    --brand-foreground: hsl(40 33.3% 91.2%); /* #f0ebe1 */
    --brand-accent: hsl(266.4 77.3% 62%);   /* #9553E9 */
    --primary: var(--brand);
    --ring: var(--brand);
    --radius: 0.5rem;
    /* ... */
}

.dark {
    /* dark values */
}
```

The `@source` lines matter. If package classes are missing from your build, check that these lines are present and match your stack.

## Changing Colors

The variables hold complete color values (for example `hsl(...)`), and `@theme inline` maps them to utilities such as `bg-primary` and `text-muted-foreground`. To rebrand, change the variables in both `:root` and `.dark`:

```css
:root {
    --brand: oklch(0.55 0.2 260);
    --brand-foreground: oklch(0.98 0 0);
}

.dark {
    --brand: oklch(0.65 0.2 260);
}
```

Panel-level colors, fonts and theme presets can also be set from PHP on the panel. See [Branding](../panel/branding.md).

## Adding Theme Tokens

Add new tokens in CSS rather than in a config file:

```css
@theme inline {
    --color-success: var(--success);
}

:root {
    --success: hsl(152 60% 40%);
}
```

Then use `bg-success`, `text-success` and so on.

## Dark Mode

Dark mode is class-based (`.dark` on `<html>`). The appearance composable/hook handles `light`, `dark` and `system`, stores the choice in `localStorage` and in an `appearance` cookie (so the server can render the right class), and follows system changes:

```typescript
// Vue
import { useAppearance } from '@/composables/useAppearance'
const { appearance, updateAppearance } = useAppearance()
updateAppearance('dark')
```

```tsx
// React
import { useAppearance } from '@/hooks/use-appearance';
const { appearance, updateAppearance } = useAppearance();
```

Use the `dark:` variant for custom styles, and prefer semantic tokens (`bg-background`, `text-muted-foreground`) because they switch automatically.

## Conventions

1. Use semantic tokens (`text-muted-foreground`) instead of raw palette colors.
2. Combine conditional classes with `cn()` from `@/lib/utils`. See [Utilities](utilities.md).
3. Style variants with `class-variance-authority`, as the UI primitives do (`buttonVariants`, `badgeVariants`).
4. Animations come from `tw-animate-css` (`animate-in`, `fade-in`, `slide-in-from-top` ...).
5. Test both themes.

## Related

- [UI Components](ui/README.md)
- [Layouts](layouts.md)
- [Tailwind CSS v4 docs](https://tailwindcss.com/docs)
