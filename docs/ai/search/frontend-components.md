---
title: Frontend Components
description: The GlobalSearch component and useGlobalSearch composable for Vue and React.
order: 2
---

# Search Frontend Components

The panel renders `GlobalSearch` automatically when global search is enabled. It reads `hasGlobalSearch`, `globalSearchEndpoint` and `globalSearchConfig` (`enabled`, `useAI`, `debounce`) from the shared panel props. Use the component directly to place the search somewhere else.

> React support requires Laravilt v1.1 or later.

## Vue

```vue
<script setup lang="ts">
import { ref } from 'vue'
import { GlobalSearch } from '@laravilt/ai'

const search = ref<InstanceType<typeof GlobalSearch>>()

function onSelect(result, group) {
  console.log(group.label, result.title)
}
</script>

<template>
  <button @click="search?.open()">Search</button>
  <GlobalSearch ref="search" placeholder="Search products, orders..." @select="onSelect" @close="() => {}" />
</template>
```

## React

```tsx
import { useRef } from 'react'
import { GlobalSearch } from '@laravilt/ai'

export function SearchButton() {
  const search = useRef<{ open: () => void; close: () => void }>(null)

  return (
    <>
      <button onClick={() => search.current?.open()}>Search</button>
      <GlobalSearch
        ref={search}
        placeholder="Search products, orders..."
        onSelect={(result, group) => console.log(group.label, result.title)}
      />
    </>
  )
}
```

## API

| Prop / event | Vue | React |
|--------------|-----|-------|
| Placeholder | `placeholder` | `placeholder` |
| Result selected | `@select(result, group)` | `onSelect(result, group)` |
| Dialog closed | `@close` | `onClose` |
| Open / close programmatically | `ref.open()`, `ref.close()` | `ref.current.open()`, `ref.current.close()` |

## Result types

```ts
interface SearchResult {
  id: string | number
  title: string
  subtitle?: string
  url: string
}

interface SearchGroup {
  resource: string
  label: string
  icon?: string
  url: string
  results: SearchResult[]
}
```

## useGlobalSearch

`useGlobalSearch(endpoint = '/laravilt-ai/search')` returns `query`, `results`, `loading`, `error`, `useAI`, `hasResults`, `totalResults`, `search()`, `debouncedSearch()` and `clear()`.
