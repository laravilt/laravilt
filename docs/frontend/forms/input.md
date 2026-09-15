---
title: Input
description: The Input primitive for text, email, password, number and file inputs.
order: 1
---

# Input

## Import

```typescript
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
```

## Usage

```vue
<script setup lang="ts">
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { ref } from 'vue'

const email = ref('')
</script>

<template>
    <div class="grid gap-2">
        <Label for="email">Email</Label>
        <Input id="email" v-model="email" type="email" placeholder="you@example.com" />
    </div>
</template>
```

```tsx
const [email, setEmail] = useState('');

<div className="grid gap-2">
    <Label htmlFor="email">Email</Label>
    <Input id="email" type="email" value={email} onChange={(e) => setEmail(e.target.value)} />
</div>;
```

Every native attribute passes through: `type` (`text`, `email`, `password`, `number`, `search`, `tel`, `url`, `file` ...), `placeholder`, `disabled`, `required`, `autocomplete` and so on.

## With an Icon

```vue
<div class="relative">
    <Search class="absolute top-1/2 left-3 size-4 -translate-y-1/2 text-muted-foreground" />
    <Input class="pl-9" placeholder="Search..." />
</div>
```

## Error State

Set `aria-invalid` to get the destructive border and ring:

```vue
<Input id="email" v-model="form.email" :aria-invalid="!!form.errors.email" />
<InputError :message="form.errors.email" />
```

## Props (Vue)

| Prop | Type | Description |
|------|------|-------------|
| `modelValue` | `string \| number` | `v-model` value |
| `defaultValue` | `string \| number` | Initial value when uncontrolled |
| `class` | `string` | Extra classes |

On React, `Input` is a plain `<input>` with styling, so it accepts all input props.

## Related

- [Select](select.md)
- [Form Inputs](README.md)
