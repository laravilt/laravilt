---
title: Switch
description: The Switch primitive for on/off settings.
order: 4
---

# Switch

## Import

```typescript
import { Switch } from '@/components/ui/switch'
```

## Usage

As with the checkbox, the Vue switch binds with plain `v-model`. The React switch uses `checked` and `onCheckedChange`.

```vue
<script setup lang="ts">
import { Label } from '@/components/ui/label'
import { Switch } from '@/components/ui/switch'
import { ref } from 'vue'

const notifications = ref(true)
</script>

<template>
    <div class="flex items-center justify-between">
        <div>
            <Label for="notifications">Email notifications</Label>
            <p class="text-sm text-muted-foreground">Receive email updates</p>
        </div>
        <Switch id="notifications" v-model="notifications" />
    </div>
</template>
```

```tsx
const [notifications, setNotifications] = useState(true);

<div className="flex items-center justify-between">
    <Label htmlFor="notifications">Email notifications</Label>
    <Switch id="notifications" checked={notifications} onCheckedChange={setNotifications} />
</div>;
```

## Props

| Vue | React | Description |
|-----|-------|-------------|
| `v-model` / `modelValue` | `checked` | On/off state |
| `@update:model-value` | `onCheckedChange` | Change handler |
| `default-value` | `defaultChecked` | Initial state when uncontrolled |
| `disabled` | `disabled` | Disabled state |

For a toggle field in a resource form, use the PHP `Toggle` field. See [Form Inputs (PHP)](../../forms/inputs/README.md).

## Related

- [Checkbox](checkbox.md)
- [Card](../ui/card.md)
