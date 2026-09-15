---
title: Button
description: The Button primitive with its variants and sizes.
order: 1
---

# Button

## Import

```typescript
import { Button } from '@/components/ui/button'
```

## Usage

```vue
<script setup lang="ts">
import { Button } from '@/components/ui/button'
import { Plus } from 'lucide-vue-next'
</script>

<template>
    <Button>Save</Button>
    <Button variant="outline">
        <Plus /> Add Item
    </Button>
    <Button variant="destructive" size="sm">Delete</Button>
    <Button size="icon" variant="ghost" aria-label="Add">
        <Plus />
    </Button>
</template>
```

```tsx
import { Button } from '@/components/ui/button';
import { Plus } from 'lucide-react';

export function Actions() {
    return (
        <>
            <Button>Save</Button>
            <Button variant="outline">
                <Plus /> Add Item
            </Button>
            <Button variant="destructive" size="sm">Delete</Button>
        </>
    );
}
```

Icons inside a button are sized automatically (`size-4`).

## As a Link

Render the button as another element with `as-child` / `asChild`:

```vue
<Button as-child>
    <Link href="/admin">Go to Dashboard</Link>
</Button>
```

```tsx
<Button asChild>
    <Link href="/admin">Go to Dashboard</Link>
</Button>
```

Here `Link` comes from `@inertiajs/vue3` or `@inertiajs/react`.

## Loading State

```vue
<script setup lang="ts">
import { Button } from '@/components/ui/button'
import { Spinner } from '@/components/ui/spinner'
</script>

<template>
    <Button :disabled="form.processing">
        <Spinner v-if="form.processing" />
        Submit
    </Button>
</template>
```

## Variants and Sizes

| `variant` | Use |
|-----------|-----|
| `default` | Primary action (brand color) |
| `secondary` | Secondary action |
| `destructive` | Delete and other dangerous actions |
| `outline` | Bordered |
| `ghost` | No background |
| `link` | Text link style |

| `size` | |
|--------|---|
| `default` | `h-9` |
| `sm` | `h-8` |
| `lg` | `h-10` |
| `icon` | Square `size-9` |

For button-styled elements that aren't a `Button`, use the exported `buttonVariants({ variant, size })` class helper.

## Related

- [Dialog](dialog.md)
- [Dropdown Menu](dropdown.md)
