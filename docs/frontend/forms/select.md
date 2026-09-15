---
title: Select
description: The Select primitive for single-choice dropdowns.
order: 2
---

# Select

## Import

```typescript
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectSeparator,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
```

## Usage

```vue
<script setup lang="ts">
import { ref } from 'vue'

const country = ref<string>()
const options = [
    { value: 'us', label: 'United States' },
    { value: 'uk', label: 'United Kingdom' },
]
</script>

<template>
    <Select v-model="country">
        <SelectTrigger class="w-[200px]">
            <SelectValue placeholder="Select a country" />
        </SelectTrigger>
        <SelectContent>
            <SelectItem v-for="o in options" :key="o.value" :value="o.value">
                {{ o.label }}
            </SelectItem>
        </SelectContent>
    </Select>
</template>
```

```tsx
<Select value={country} onValueChange={setCountry}>
    <SelectTrigger className="w-[200px]">
        <SelectValue placeholder="Select a country" />
    </SelectTrigger>
    <SelectContent>
        {options.map((o) => (
            <SelectItem key={o.value} value={o.value}>
                {o.label}
            </SelectItem>
        ))}
    </SelectContent>
</Select>
```

## Groups

```vue
<SelectContent>
    <SelectGroup>
        <SelectLabel>Fruits</SelectLabel>
        <SelectItem value="apple">Apple</SelectItem>
        <SelectItem value="banana">Banana</SelectItem>
    </SelectGroup>
    <SelectSeparator />
    <SelectGroup>
        <SelectLabel>Vegetables</SelectLabel>
        <SelectItem value="carrot">Carrot</SelectItem>
    </SelectGroup>
</SelectContent>
```

Add `disabled` to `Select` or to a single `SelectItem` to disable it.

This primitive is a simple dropdown. For searchable, relationship-backed or multi-select fields in resource forms, use the PHP `Select` field. See [Selection Fields](../../forms/selection/README.md).

## Related

- [Input](input.md)
- [Checkbox](checkbox.md)
