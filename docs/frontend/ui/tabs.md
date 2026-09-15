---
title: Tabs
description: The Tabs primitive for switching between panels of content.
order: 9
---

# Tabs

This is the client-side primitive. For tabs inside forms and infolists, use the PHP `Tabs` schema component. See [Schemas](../../schemas/README.md).

## Import

```typescript
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs'
```

## Usage

```vue
<template>
    <Tabs default-value="account" class="w-full">
        <TabsList>
            <TabsTrigger value="account">Account</TabsTrigger>
            <TabsTrigger value="password">Password</TabsTrigger>
        </TabsList>
        <TabsContent value="account">Account settings...</TabsContent>
        <TabsContent value="password">Password settings...</TabsContent>
    </Tabs>
</template>
```

```tsx
<Tabs defaultValue="account" className="w-full">
    <TabsList>
        <TabsTrigger value="account">Account</TabsTrigger>
        <TabsTrigger value="password">Password</TabsTrigger>
    </TabsList>
    <TabsContent value="account">Account settings...</TabsContent>
    <TabsContent value="password">Password settings...</TabsContent>
</Tabs>
```

## Controlled

```vue
<Tabs v-model="tab">...</Tabs>
```

```tsx
<Tabs value={tab} onValueChange={setTab}>...</Tabs>
```

Pass `disabled` on a `TabsTrigger` to disable it.

## Related

- [Card](card.md)
