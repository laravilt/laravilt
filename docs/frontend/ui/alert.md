---
title: Alert
description: The Alert primitive for inline messages.
order: 4
---

# Alert

## Import

```typescript
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert'
```

## Usage

```vue
<script setup lang="ts">
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert'
import { AlertCircle, Info } from 'lucide-vue-next'
</script>

<template>
    <Alert>
        <Info />
        <AlertTitle>Heads up</AlertTitle>
        <AlertDescription>Your trial ends in 3 days.</AlertDescription>
    </Alert>

    <Alert variant="destructive">
        <AlertCircle />
        <AlertTitle>Error</AlertTitle>
        <AlertDescription>Your session has expired.</AlertDescription>
    </Alert>
</template>
```

```tsx
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { AlertCircle } from 'lucide-react';

<Alert variant="destructive">
    <AlertCircle />
    <AlertTitle>Error</AlertTitle>
    <AlertDescription>Your session has expired.</AlertDescription>
</Alert>;
```

## Variants

| `variant` | Description |
|-----------|-------------|
| `default` | Neutral |
| `destructive` | Error |

For success or warning styles, pass classes (for example `class="border-emerald-500/50 text-emerald-700"`) or add a variant to `alertVariants`. For transient messages, use [notifications](../../notifications/README.md) instead.

## Related

- [Badge](badge.md)
- [Dialog](dialog.md)
