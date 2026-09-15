---
title: Frontend Components
description: The AIChat component and useAI composable for Vue and React.
order: 3
---

# Chat Frontend Components

The package ships the chat UI for both stacks: Vue components in `resources/js` and React twins in `resources/react`. The panel's AI chat page already renders `AIChat`, so you only need these to embed chat somewhere else.

> React support requires Laravilt v1.1 or later.

## AIChat

### Vue

```vue
<script setup lang="ts">
import { AIChat } from '@laravilt/ai'

function onSessionChange(session) {
  console.log('Active session', session.id)
}
</script>

<template>
  <AIChat :show-sidebar="false" endpoint="/laravilt-ai" @session-change="onSessionChange" />
</template>
```

### React

```tsx
import { AIChat } from '@laravilt/ai'

export default function Assistant() {
  return (
    <AIChat
      showSidebar={false}
      endpoint="/laravilt-ai"
      onSessionChange={(session) => console.log('Active session', session.id)}
    />
  )
}
```

### Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `initialSession` | `Session` | none | Session to open on mount |
| `showSidebar` | `boolean` | `true` | Show the sessions sidebar |
| `endpoint` | `string` | `/laravilt-ai` | Base URL of the AI API |

Vue emits `sessionChange(session)`. React uses the `onSessionChange` callback prop.

## useAI composable

`useAI(endpoint = '/laravilt-ai')` exposes the chat API without the UI (Vue refs or React state):

| Member | Description |
|--------|-------------|
| `config`, `loading`, `error` | Loaded configuration and request state |
| `selectedProvider`, `selectedModel` | Current selection |
| `isConfigured`, `availableProviders`, `availableModels` | Derived values |
| `loadConfig()` | Fetch `/config` |
| `chat()` | Send a message and get a full response |
| `streamChat()` | Stream a response from `/stream` |
