---
title: Tooltip
description: The Tooltip primitive for hover hints.
order: 10
---

# Tooltip

## Import

```typescript
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip'
```

Tooltips need a `TooltipProvider` above them. On React, `app.tsx` already wraps the app in one. On Vue, the sidebar provider supplies one inside the app shell, so wrap your own tooltips in `TooltipProvider` when they render outside it.

## Usage

```vue
<script setup lang="ts">
import { Button } from '@/components/ui/button'
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip'
import { Plus } from 'lucide-vue-next'
</script>

<template>
    <TooltipProvider>
        <Tooltip>
            <TooltipTrigger as-child>
                <Button size="icon" variant="outline" aria-label="Add">
                    <Plus />
                </Button>
            </TooltipTrigger>
            <TooltipContent side="top">Add item</TooltipContent>
        </Tooltip>
    </TooltipProvider>
</template>
```

```tsx
<Tooltip>
    <TooltipTrigger asChild>
        <Button size="icon" variant="outline" aria-label="Add">
            <Plus />
        </Button>
    </TooltipTrigger>
    <TooltipContent side="top">Add item</TooltipContent>
</Tooltip>
```

## Props

| Prop | On | Description |
|------|----|-------------|
| `side` | `TooltipContent` | `top`, `right`, `bottom`, `left` |
| `align` | `TooltipContent` | `start`, `center`, `end` |
| `delay-duration` / `delayDuration` | `TooltipProvider` | Open delay in ms |

## Related

- [Button](button.md)
