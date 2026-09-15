---
title: Checkbox
description: The Checkbox primitive for boolean and multi-choice inputs.
order: 3
---

# Checkbox

## Import

```typescript
import { Checkbox } from '@/components/ui/checkbox'
```

## Usage

The Vue checkbox is built on Reka UI v2 and binds with plain `v-model`, not `v-model:checked`. The React checkbox uses `checked` and `onCheckedChange`.

```vue
<script setup lang="ts">
import { Checkbox } from '@/components/ui/checkbox'
import { Label } from '@/components/ui/label'
import { ref } from 'vue'

const accepted = ref(false)
</script>

<template>
    <div class="flex items-center gap-2">
        <Checkbox id="terms" v-model="accepted" />
        <Label for="terms">Accept terms and conditions</Label>
    </div>
</template>
```

```tsx
const [accepted, setAccepted] = useState(false);

<div className="flex items-center gap-2">
    <Checkbox id="terms" checked={accepted} onCheckedChange={(v) => setAccepted(v === true)} />
    <Label htmlFor="terms">Accept terms and conditions</Label>
</div>;
```

## Checkbox Group

```vue
<script setup lang="ts">
const channels = ref<string[]>([])

function toggle(value: string, checked: boolean | 'indeterminate') {
    channels.value = checked === true
        ? [...channels.value, value]
        : channels.value.filter((v) => v !== value)
}
</script>

<template>
    <div v-for="c in ['email', 'sms', 'push']" :key="c" class="flex items-center gap-2">
        <Checkbox
            :id="c"
            :model-value="channels.includes(c)"
            @update:model-value="(v) => toggle(c, v)"
        />
        <Label :for="c">{{ c }}</Label>
    </div>
</template>
```

## Props

| Vue | React | Description |
|-----|-------|-------------|
| `v-model` / `modelValue` | `checked` | `true`, `false` or `'indeterminate'` |
| `@update:model-value` | `onCheckedChange` | Change handler |
| `default-value` | `defaultChecked` | Initial state when uncontrolled |
| `disabled` | `disabled` | Disabled state |

## Related

- [Switch](switch.md)
- [Form Inputs](README.md)
