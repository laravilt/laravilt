---
title: Avatar
description: The Avatar primitive with an image and initials fallback.
order: 5
---

# Avatar

## Import

```typescript
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
```

## Usage

```vue
<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import { useInitials } from '@/composables/useInitials'

const props = defineProps<{ user: { name: string; avatar?: string } }>()
const { getInitials } = useInitials()
</script>

<template>
    <Avatar class="size-8">
        <AvatarImage v-if="user.avatar" :src="user.avatar" :alt="user.name" />
        <AvatarFallback>{{ getInitials(user.name) }}</AvatarFallback>
    </Avatar>
</template>
```

```tsx
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { useInitials } from '@/hooks/use-initials';

export function UserAvatar({ user }: { user: { name: string; avatar?: string } }) {
    const getInitials = useInitials();

    return (
        <Avatar className="size-8">
            <AvatarImage src={user.avatar} alt={user.name} />
            <AvatarFallback>{getInitials(user.name)}</AvatarFallback>
        </Avatar>
    );
}
```

The fallback shows while the image loads or if it fails. Change the size and shape with classes (`size-10`, `rounded-lg`). The shell's `UserInfo` component uses this same pattern.

## Related

- [Dropdown Menu](dropdown.md)
