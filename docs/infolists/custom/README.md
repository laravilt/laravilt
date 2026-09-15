---
title: Custom Entries
description: Build your own infolist entry types with a PHP class and a frontend component.
order: 3
---

# Custom Entries

A custom entry has two parts. A PHP class extends `Laravilt\Infolists\Entries\Entry` and passes its options in `toLaraviltProps()`. A Vue or React component renders it.

```
PHP Entry class → toLaraviltProps() → frontend component
```

> React support requires Laravilt v1.1 or later.

## Pages

1. [Creating Entries](creating-entries.md): the PHP class
2. [Frontend Components](frontend-components.md): the Vue or React component and how it's resolved
