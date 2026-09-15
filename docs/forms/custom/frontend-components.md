---
title: Frontend Components
description: Build and register the Vue or React component for a custom field.
order: 2
---

# Frontend Components

Every built-in field ships in both stacks. Vue components live in `resources/js/components/fields/*.vue` and React components in `resources/react/components/fields/*.tsx` of `laravilt/forms`. Your custom field needs a component for the stack you use (`LARAVILT_FRONTEND`).

> React support requires Laravilt v1.1 or later.

`make:form-component --vue` or `--react` writes a starter component to `resources/js/components/forms/{name}.vue` or `.tsx`.

## Props

The component receives the props from the field's `toLaraviltProps()`: `name`, `label`, `placeholder`, `helperText`, `disabled`, `readonly`, `required`, the current value, and your custom props. It reports changes through `update:modelValue` (Vue) or `onUpdateModelValue` (React).

## Vue

```vue
<script setup lang="ts">
const props = defineProps<{
  name?: string
  modelValue?: string | null
  disabled?: boolean
  emojis?: string[]
}>()

const emit = defineEmits<{ 'update:modelValue': [value: string] }>()
</script>

<template>
  <div class="flex gap-2">
    <button
      v-for="emoji in emojis"
      :key="emoji"
      type="button"
      :disabled="disabled"
      class="rounded-md border px-2 py-1"
      :class="{ 'ring-2 ring-primary': emoji === modelValue }"
      @click="emit('update:modelValue', emoji)"
    >
      {{ emoji }}
    </button>
    <input v-if="name" type="hidden" :name="name" :value="modelValue ?? ''" />
  </div>
</template>
```

Register it globally with the `laravilt-` prefix in your Vue app setup:

```ts
import EmojiPicker from './components/forms/emoji-picker.vue'

app.component('laravilt-emoji-picker', EmojiPicker)
```

## React

```tsx
interface Props {
    name?: string;
    modelValue?: string | null;
    disabled?: boolean;
    emojis?: string[];
    onUpdateModelValue?: (value: string) => void;
}

export default function EmojiPicker({ name, modelValue, disabled, emojis = [], onUpdateModelValue }: Props) {
    return (
        <div className="flex gap-2">
            {emojis.map((emoji) => (
                <button
                    key={emoji}
                    type="button"
                    disabled={disabled}
                    className={`rounded-md border px-2 py-1 ${emoji === modelValue ? 'ring-2 ring-primary' : ''}`}
                    onClick={() => onUpdateModelValue?.(emoji)}
                >
                    {emoji}
                </button>
            ))}
            {name && <input type="hidden" name={name} value={modelValue ?? ''} />}
        </div>
    );
}
```

Register it in the shared component registry:

```ts
import { registerComponent } from '@laravilt/support/composables/registry';
import EmojiPicker from './components/forms/emoji-picker';

registerComponent('laravilt-emoji-picker', EmojiPicker);
```

The React schema renderer (`Schema.tsx`) falls back to this registry for component types it doesn't know. A field class `EmojiPicker` sends the type `emoji_picker`, which resolves to `laravilt-emoji-picker`.

On the Vue stack, the schema renderer (`Schema.vue`) does the same with the app's global components. For a type it doesn't know, it tries a component registered under the type itself, then one registered as `laravilt-<type with _ replaced by ->`. So `app.component('laravilt-emoji-picker', EmojiPicker)` above is enough for the field to render in resource forms. `LaraviltComponentRenderer` resolves the same `laravilt-*` names on both stacks.

## UI building blocks

The built-in fields use shadcn-vue / reka-ui (Vue) or shadcn/ui (React), Lucide icons (`lucide-vue-next` / `lucide-react`) and Tailwind CSS v4 classes. Using the same building blocks keeps custom fields consistent with the rest of the panel.
