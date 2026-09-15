---
title: Dialog
description: The Dialog primitive for modal windows.
order: 6
---

# Dialog

For confirmations and forms that run server-side logic, prefer a PHP [action](../../actions/README.md) with `->requiresConfirmation()` or a modal form. Use this primitive for purely client-side modals in your own pages.

## Import

```typescript
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog'
```

## Usage

```vue
<script setup lang="ts">
import { Button } from '@/components/ui/button'
import {
    Dialog, DialogClose, DialogContent, DialogDescription,
    DialogFooter, DialogHeader, DialogTitle, DialogTrigger,
} from '@/components/ui/dialog'
</script>

<template>
    <Dialog>
        <DialogTrigger as-child>
            <Button variant="outline">Open</Button>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Confirm action</DialogTitle>
                <DialogDescription>Are you sure you want to proceed?</DialogDescription>
            </DialogHeader>
            <DialogFooter>
                <DialogClose as-child>
                    <Button variant="outline">Cancel</Button>
                </DialogClose>
                <Button @click="confirm">Confirm</Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
```

```tsx
<Dialog>
    <DialogTrigger asChild>
        <Button variant="outline">Open</Button>
    </DialogTrigger>
    <DialogContent>
        <DialogHeader>
            <DialogTitle>Confirm action</DialogTitle>
            <DialogDescription>Are you sure you want to proceed?</DialogDescription>
        </DialogHeader>
        <DialogFooter>
            <DialogClose asChild>
                <Button variant="outline">Cancel</Button>
            </DialogClose>
            <Button onClick={confirm}>Confirm</Button>
        </DialogFooter>
    </DialogContent>
</Dialog>
```

## Controlled

```vue
<Dialog v-model:open="open">...</Dialog>
```

```tsx
<Dialog open={open} onOpenChange={setOpen}>...</Dialog>
```

Vue also exports `DialogScrollContent` for long content that scrolls with the overlay.

## Related

- [Sheet](sheet.md)
- [Button](button.md)
