---
title: CodeEntry
description: Syntax-highlighted code blocks.
order: 6
---

# CodeEntry

Displays a syntax-highlighted code block.

```php
use Laravilt\Infolists\Entries\CodeEntry;

CodeEntry::make('payload')->json();
CodeEntry::make('source')->php()->lineNumbers()->maxHeight(300)->copyable();
CodeEntry::make('script')->language('ruby');
```

## API reference

| Method | Description |
|--------|-------------|
| `language(string)` | Any language name |
| `json()` / `php()` / `javascript()` / `typescript()` / `python()` / `sql()` / `yaml()` / `html()` / `css()` | Shortcuts |
| `lineNumbers(bool)` | Line numbers |
| `maxHeight(int)` | Maximum height in pixels |
| `copyable(bool)` | Copy button |
