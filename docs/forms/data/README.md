---
title: Data
description: Fields for nested and structured data.
order: 6
---

# Data

Fields for nested and structured data.

| Component | Description | Typical use |
|-----------|-------------|-------------|
| [Repeater](repeater.md) | Repeating groups of fields | Line items, contacts |
| [Builder](builder.md) | Typed content blocks | Page content |
| [KeyValue](key-value.md) | Key-value pairs | Settings, metadata |

Store these fields in a JSON or array-cast column, or use `Repeater::relationship()` for a HasMany relation.
