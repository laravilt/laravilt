---
title: Sheet
description: The Sheet primitive for slide-out panels.
order: 7
---

# Sheet

A dialog that slides in from an edge of the screen. The mobile sidebar uses it.

## Import

```typescript
import {
    Sheet,
    SheetClose,
    SheetContent,
    SheetDescription,
    SheetFooter,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/components/ui/sheet'
```

## Usage

```vue
<template>
    <Sheet>
        <SheetTrigger as-child>
            <Button variant="outline">Filters</Button>
        </SheetTrigger>
        <SheetContent side="right">
            <SheetHeader>
                <SheetTitle>Filters</SheetTitle>
                <SheetDescription>Narrow down the results.</SheetDescription>
            </SheetHeader>
            <div class="p-4">
                <!-- content -->
            </div>
            <SheetFooter>
                <SheetClose as-child>
                    <Button>Apply</Button>
                </SheetClose>
            </SheetFooter>
        </SheetContent>
    </Sheet>
</template>
```

```tsx
<Sheet>
    <SheetTrigger asChild>
        <Button variant="outline">Filters</Button>
    </SheetTrigger>
    <SheetContent side="right">
        <SheetHeader>
            <SheetTitle>Filters</SheetTitle>
            <SheetDescription>Narrow down the results.</SheetDescription>
        </SheetHeader>
    </SheetContent>
</Sheet>
```

## Props

| Prop (`SheetContent`) | Values | Default |
|------|--------|---------|
| `side` | `top`, `right`, `bottom`, `left` | `right` |

Control it like a dialog: `v-model:open` (Vue) or `open` + `onOpenChange` (React).

## Related

- [Dialog](dialog.md)
