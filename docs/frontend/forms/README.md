---
title: Form Inputs
description: The input, select, checkbox and switch primitives for hand-built forms in your own pages.
order: 6
---

# Form Inputs

Resource forms are built in PHP with the [Forms](../../forms/README.md) package and rendered for you. The primitives on these pages are for **hand-built** Inertia pages. They are the shadcn components published into `resources/js/components/ui/`.

> React support requires Laravilt v1.1 or later.

| Primitive | Import | Page |
|-----------|--------|------|
| Input | `@/components/ui/input` | [Input](input.md) |
| Select | `@/components/ui/select` | [Select](select.md) |
| Checkbox | `@/components/ui/checkbox` | [Checkbox](checkbox.md) |
| Switch | `@/components/ui/switch` | [Switch](switch.md) |
| Label | `@/components/ui/label` | Used on every page |
| Textarea | `@/components/ui/textarea` | Same API as Input |
| RadioGroup | `@/components/ui/radio-group` | `RadioGroup` + `RadioGroupItem` |

The shell also ships an `InputError` component (`@/components/InputError.vue` / `@/components/input-error`) that displays a validation message.

## Example with Inertia useForm

```vue
<script setup lang="ts">
import InputError from '@/components/InputError.vue'
import { Button } from '@/components/ui/button'
import { Checkbox } from '@/components/ui/checkbox'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { useForm } from '@inertiajs/vue3'

const form = useForm({ email: '', terms: false })
</script>

<template>
    <form class="space-y-4" @submit.prevent="form.post('/subscribe')">
        <div class="grid gap-2">
            <Label for="email">Email</Label>
            <Input id="email" v-model="form.email" type="email" />
            <InputError :message="form.errors.email" />
        </div>
        <div class="flex items-center gap-2">
            <Checkbox id="terms" v-model="form.terms" />
            <Label for="terms">Accept terms</Label>
        </div>
        <Button type="submit" :disabled="form.processing">Submit</Button>
    </form>
</template>
```

```tsx
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useForm } from '@inertiajs/react';

export default function Subscribe() {
    const { data, setData, post, errors, processing } = useForm({ email: '', terms: false });

    return (
        <form className="space-y-4" onSubmit={(e) => { e.preventDefault(); post('/subscribe'); }}>
            <div className="grid gap-2">
                <Label htmlFor="email">Email</Label>
                <Input id="email" type="email" value={data.email} onChange={(e) => setData('email', e.target.value)} />
                <InputError message={errors.email} />
            </div>
            <div className="flex items-center gap-2">
                <Checkbox id="terms" checked={data.terms} onCheckedChange={(v) => setData('terms', v === true)} />
                <Label htmlFor="terms">Accept terms</Label>
            </div>
            <Button type="submit" disabled={processing}>Submit</Button>
        </form>
    );
}
```

## Related

- [UI Components](../ui/README.md)
- [Forms](../../forms/README.md) (the PHP form builder; `php artisan make:form-component` creates custom field types)
