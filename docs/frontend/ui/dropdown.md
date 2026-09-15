---
title: Dropdown Menu
description: The DropdownMenu primitive for action menus.
order: 8
---

# Dropdown Menu

## Import

```typescript
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuShortcut,
    DropdownMenuSub,
    DropdownMenuSubContent,
    DropdownMenuSubTrigger,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
```

`DropdownMenuCheckboxItem`, `DropdownMenuRadioGroup` and `DropdownMenuRadioItem` are also exported.

## Usage

```vue
<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button variant="outline">Options</Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end" class="w-48">
            <DropdownMenuLabel>Actions</DropdownMenuLabel>
            <DropdownMenuSeparator />
            <DropdownMenuItem @select="edit">Edit</DropdownMenuItem>
            <DropdownMenuItem>
                Duplicate
                <DropdownMenuShortcut>⌘D</DropdownMenuShortcut>
            </DropdownMenuItem>
            <DropdownMenuSeparator />
            <DropdownMenuItem variant="destructive">Delete</DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
```

```tsx
<DropdownMenu>
    <DropdownMenuTrigger asChild>
        <Button variant="outline">Options</Button>
    </DropdownMenuTrigger>
    <DropdownMenuContent align="end" className="w-48">
        <DropdownMenuLabel>Actions</DropdownMenuLabel>
        <DropdownMenuSeparator />
        <DropdownMenuItem onSelect={edit}>Edit</DropdownMenuItem>
        <DropdownMenuItem variant="destructive">Delete</DropdownMenuItem>
    </DropdownMenuContent>
</DropdownMenu>
```

For a navigation link inside a menu, wrap an Inertia `Link` with `as-child` / `asChild` on `DropdownMenuItem`. The user menu (`UserMenuContent`) works this way.

Row actions in resource tables are defined in PHP. See [Table Actions](../../tables/actions/README.md).

## Related

- [Button](button.md)
- [Avatar](avatar.md)
