---
title: Card
description: The Card primitive and its header, content and footer parts.
order: 2
---

# Card

## Import

```typescript
import {
    Card,
    CardAction,      // Vue only
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
```

## Usage

```vue
<template>
    <Card>
        <CardHeader>
            <CardTitle>Users</CardTitle>
            <CardDescription>Everyone with panel access</CardDescription>
            <CardAction>
                <Button size="sm">Add User</Button>
            </CardAction>
        </CardHeader>
        <CardContent>
            <p>Card content goes here.</p>
        </CardContent>
        <CardFooter>
            <Button variant="outline">View all</Button>
        </CardFooter>
    </Card>
</template>
```

```tsx
<Card>
    <CardHeader>
        <CardTitle>Users</CardTitle>
        <CardDescription>Everyone with panel access</CardDescription>
    </CardHeader>
    <CardContent>
        <p>Card content goes here.</p>
    </CardContent>
    <CardFooter>
        <Button variant="outline">View all</Button>
    </CardFooter>
</Card>
```

## Stat Card

```vue
<Card>
    <CardHeader>
        <CardDescription>Total Revenue</CardDescription>
        <CardTitle class="text-3xl">$45,231</CardTitle>
    </CardHeader>
    <CardContent>
        <p class="text-xs text-muted-foreground">+20.1% from last month</p>
    </CardContent>
</Card>
```

For dashboard stats that come from the server, use a stats widget instead. See [Stats Overview](../../widgets/types/stats-overview.md).

## Parts

| Component | Description |
|-----------|-------------|
| `Card` | Root container |
| `CardHeader` | Header area |
| `CardTitle` / `CardDescription` | Heading and subtext |
| `CardAction` | Top-right header slot (Vue) |
| `CardContent` | Body |
| `CardFooter` | Footer actions |

## Related

- [Badge](badge.md)
- [Button](button.md)
