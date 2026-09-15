---
title: Styling Guide
description: Tailwind CSS styling conventions and theming for Laravilt.
---

# Styling Guide

Laravilt uses Tailwind CSS for styling with custom theme extensions and CSS variables for dynamic theming.

## Tailwind Configuration

### Theme Colors

Laravilt extends Tailwind with custom colors:

```javascript
// tailwind.config.js
module.exports = {
    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: 'hsl(var(--primary))',
                    foreground: 'hsl(var(--primary-foreground))',
                },
                secondary: {
                    DEFAULT: 'hsl(var(--secondary))',
                    foreground: 'hsl(var(--secondary-foreground))',
                },
                destructive: {
                    DEFAULT: 'hsl(var(--destructive))',
                    foreground: 'hsl(var(--destructive-foreground))',
                },
                muted: {
                    DEFAULT: 'hsl(var(--muted))',
                    foreground: 'hsl(var(--muted-foreground))',
                },
                accent: {
                    DEFAULT: 'hsl(var(--accent))',
                    foreground: 'hsl(var(--accent-foreground))',
                },
                border: 'hsl(var(--border))',
                input: 'hsl(var(--input))',
                ring: 'hsl(var(--ring))',
                background: 'hsl(var(--background))',
                foreground: 'hsl(var(--foreground))',
            },
        },
    },
}
```

### CSS Variables

Theme colors are defined as CSS variables for light/dark mode:

```css
/* resources/css/app.css */
@layer base {
    :root {
        --background: 0 0% 100%;
        --foreground: 240 10% 3.9%;
        --card: 0 0% 100%;
        --card-foreground: 240 10% 3.9%;
        --popover: 0 0% 100%;
        --popover-foreground: 240 10% 3.9%;
        --primary: 3.5 100% 56.3%;     /* Laravilt red #FF2D20 */
        --primary-foreground: 40 33.3% 91.2%; /* #f0ebe1 */
        --brand-accent: 266.4 77.3% 62%; /* Laravilt purple #9553E9 */
        --secondary: 240 4.8% 95.9%;
        --secondary-foreground: 240 5.9% 10%;
        --muted: 240 4.8% 95.9%;
        --muted-foreground: 240 3.8% 46.1%;
        --accent: 240 4.8% 95.9%;
        --accent-foreground: 240 5.9% 10%;
        --destructive: 0 84.2% 60.2%;
        --destructive-foreground: 0 0% 98%;
        --border: 240 5.9% 90%;
        --input: 240 5.9% 90%;
        --ring: 3.5 100% 56.3%;
        --radius: 0.5rem;
    }

    .dark {
        --background: 240 10% 3.9%;
        --foreground: 0 0% 98%;
        --card: 240 10% 3.9%;
        --card-foreground: 0 0% 98%;
        --popover: 240 10% 3.9%;
        --popover-foreground: 0 0% 98%;
        --primary: 3.5 100% 56.3%;
        --primary-foreground: 40 33.3% 91.2%;
        --brand-accent: 266.4 77.3% 62%;
        --secondary: 240 3.7% 15.9%;
        --secondary-foreground: 0 0% 98%;
        --muted: 240 3.7% 15.9%;
        --muted-foreground: 240 5% 64.9%;
        --accent: 240 3.7% 15.9%;
        --accent-foreground: 0 0% 98%;
        --destructive: 0 62.8% 30.6%;
        --destructive-foreground: 0 0% 98%;
        --border: 240 3.7% 15.9%;
        --input: 240 3.7% 15.9%;
        --ring: 3.5 100% 56.3%;
    }
}
```

## Using the cn() Utility

Always use `cn()` for combining classes:

```vue
<script setup>
import { cn } from '@/lib/utils'

const props = defineProps<{
    variant?: 'default' | 'destructive'
    size?: 'sm' | 'md' | 'lg'
}>()
</script>

<template>
    <button
        :class="cn(
            'inline-flex items-center justify-center rounded-md font-medium transition-colors',
            'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring',
            {
                'bg-primary text-primary-foreground hover:bg-primary/90': variant === 'default',
                'bg-destructive text-destructive-foreground hover:bg-destructive/90': variant === 'destructive',
            },
            {
                'h-8 px-3 text-sm': size === 'sm',
                'h-10 px-4': size === 'md',
                'h-12 px-6 text-lg': size === 'lg',
            }
        )"
    >
        <slot />
    </button>
</template>
```

## Badge Colors

Badge variants available:

```vue
<template>
    <Badge variant="default">Default</Badge>
    <Badge variant="primary">Primary</Badge>
    <Badge variant="secondary">Secondary</Badge>
    <Badge variant="success">Success</Badge>
    <Badge variant="danger">Danger</Badge>
    <Badge variant="warning">Warning</Badge>
    <Badge variant="info">Info</Badge>
    <Badge variant="gray">Gray</Badge>
    <Badge variant="outline">Outline</Badge>
    <Badge variant="destructive">Destructive</Badge>
</template>
```

## Dark Mode

### Automatic Detection

Laravilt respects system preferences and allows manual override:

```typescript
// Theme management
type Theme = 'light' | 'dark' | 'system'

const setTheme = (theme: Theme) => {
    if (theme === 'system') {
        const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches
        document.documentElement.classList.toggle('dark', systemDark)
    } else {
        document.documentElement.classList.toggle('dark', theme === 'dark')
    }
    localStorage.setItem('theme', theme)
}
```

### Styling for Dark Mode

Use Tailwind's `dark:` variant:

```vue
<template>
    <div class="bg-white dark:bg-gray-900">
        <h1 class="text-gray-900 dark:text-white">
            Title
        </h1>
        <p class="text-gray-600 dark:text-gray-400">
            Description
        </p>
    </div>
</template>
```

## Component Styling Patterns

### Card Pattern

```vue
<template>
    <div class="rounded-xl border border-border bg-card p-6 shadow-sm">
        <h3 class="text-lg font-semibold text-card-foreground">
            Title
        </h3>
        <p class="mt-2 text-muted-foreground">
            Content
        </p>
    </div>
</template>
```

### Form Input Pattern

```vue
<template>
    <div class="space-y-2">
        <label class="text-sm font-medium text-foreground">
            Label
        </label>
        <input
            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
            placeholder="Enter value..."
        />
        <p class="text-sm text-muted-foreground">
            Helper text
        </p>
    </div>
</template>
```

### Button States

```vue
<template>
    <button
        :class="cn(
            'inline-flex items-center justify-center rounded-md px-4 py-2 text-sm font-medium',
            'transition-colors focus-visible:outline-none focus-visible:ring-2',
            'disabled:pointer-events-none disabled:opacity-50',
            'bg-primary text-primary-foreground hover:bg-primary/90',
            'active:scale-[0.98]'
        )"
        :disabled="loading"
    >
        <Spinner v-if="loading" class="mr-2 h-4 w-4 animate-spin" />
        {{ loading ? 'Loading...' : 'Submit' }}
    </button>
</template>
```

## Animations

### Tailwind Animations

```css
@layer utilities {
    .animate-fade-in {
        animation: fade-in 0.2s ease-out;
    }

    .animate-slide-in {
        animation: slide-in 0.3s ease-out;
    }

    .animate-scale-in {
        animation: scale-in 0.2s ease-out;
    }
}

@keyframes fade-in {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slide-in {
    from { transform: translateY(-10px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

@keyframes scale-in {
    from { transform: scale(0.95); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}
```

### Vue Transitions

```vue
<template>
    <Transition name="fade">
        <div v-if="show">Content</div>
    </Transition>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
```

## Responsive Design

### Breakpoints

```css
/* Tailwind default breakpoints */
sm: 640px   /* Small devices */
md: 768px   /* Tablets */
lg: 1024px  /* Laptops */
xl: 1280px  /* Desktops */
2xl: 1536px /* Large screens */
```

### Mobile-First Approach

```vue
<template>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        <!-- Cards -->
    </div>
</template>
```

## Best Practices

1. **Use semantic color names** - `text-muted-foreground` instead of `text-gray-500`
2. **Always support dark mode** - Add `dark:` variants for custom styles
3. **Use CSS variables** - For colors that need to change with theme
4. **Leverage cn()** - For conditional and merged classes
5. **Keep specificity low** - Use Tailwind utilities over custom CSS
6. **Test both themes** - Verify your components in light and dark mode
