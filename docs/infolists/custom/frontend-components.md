---
title: Frontend Components
description: Build the Vue or React component for a custom infolist entry.
order: 2
---

# Frontend Components

The built-in entries ship in both stacks. Vue components live in `resources/js/components/entries/*.vue` and React components in `resources/react/components/entries/*.tsx` of `laravilt/infolists`.

> React support requires Laravilt v1.1 or later.

The component receives the entry's props: `name`, `label`, `state`, `icon`, `color`, plus your custom props (e.g. `maxValue`).

## Vue

```vue
<script setup lang="ts">
import { computed } from 'vue'

const props = defineProps<{ label?: string; state?: number; maxValue?: number }>()

const percent = computed(() => Math.min(100, ((props.state ?? 0) / (props.maxValue || 100)) * 100))
</script>

<template>
  <div class="space-y-1">
    <span class="text-sm text-muted-foreground">{{ label }}</span>
    <div class="h-2 rounded-full bg-muted">
      <div class="h-2 rounded-full bg-primary" :style="{ width: `${percent}%` }" />
    </div>
  </div>
</template>
```

## React

```tsx
import { registerComponent } from '@laravilt/support/composables/registry';

interface Props {
    label?: string;
    state?: number;
    maxValue?: number;
}

export default function ProgressEntry({ label, state = 0, maxValue = 100 }: Props) {
    const percent = Math.min(100, (state / (maxValue || 100)) * 100);

    return (
        <div className="space-y-1">
            <span className="text-sm text-muted-foreground">{label}</span>
            <div className="h-2 rounded-full bg-muted">
                <div className="h-2 rounded-full bg-primary" style={{ width: `${percent}%` }} />
            </div>
        </div>
    );
}

registerComponent('laravilt-progress-entry', ProgressEntry);
```

## How entries are resolved

- **React:** the schema renderer (`Schema.tsx`) looks up unknown component types in the shared registry, so the `registerComponent('laravilt-progress-entry', …)` call above is enough there. The standalone `InfoList` component uses a fixed map of the eight built-in entries and shows unknown types as a `TextEntry`.
- **Vue:** the schema renderer (`Schema.vue`) falls back to the app's global components. It tries the type itself, then `laravilt-<type with _ replaced by ->`. Register the entry with `app.component('laravilt-progress-entry', ProgressEntry)` and it renders in view pages. The standalone `InfoList` component uses a fixed map of the eight built-in entries and shows unknown types as a `TextEntry`.
