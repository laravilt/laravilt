---
title: Badge
description: The Badge primitive for status labels and counts.
order: 3
---

# Badge

## Import

```typescript
import { Badge } from '@/components/ui/badge'
```

## Usage

```vue
<template>
    <Badge>New</Badge>
    <Badge variant="secondary">Draft</Badge>
    <Badge variant="success">Active</Badge>
    <Badge variant="danger">Banned</Badge>
</template>
```

```tsx
<Badge>New</Badge>
<Badge variant="secondary">Draft</Badge>
<Badge variant="destructive">Banned</Badge>
```

## Variants

| `variant` | Vue | React |
|-----------|-----|-------|
| `default`, `secondary`, `destructive`, `outline` | Yes | Yes |
| `primary`, `success`, `danger`, `warning`, `info`, `gray` | Yes | No (add them to `badgeVariants` in `ui/badge.tsx` if needed) |

The Vue semantic variants are the ones `NavMain` uses for navigation badges (`badgeColor`).

Table badge columns and navigation badges are configured in PHP, so you only need this component in your own pages.

## Related

- [Card](card.md)
- [App Shell Components](../components.md)
