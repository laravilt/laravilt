---
title: CodeEditor
description: Syntax-highlighted code editor built on CodeMirror 6.
order: 4
---

# CodeEditor

A code editor with syntax highlighting, built on CodeMirror 6.

```php
use Laravilt\Forms\Components\CodeEditor;
use Laravilt\Forms\Components\CodeEditor\Language;

CodeEditor::make('php_code')->language(Language::PHP);
CodeEditor::make('config')->language('json');
CodeEditor::make('styles')->language('css')->darkTheme();
CodeEditor::make('snippet')->readonly();
```

`language()` accepts a `Language` enum case or its string value. The cases include `javascript`, `typescript`, `php`, `python`, `java`, `html`, `css`, `json`, `xml`, `yaml`, `markdown`, `sql`, `bash`, `vue`, `jsx` and more.

## API reference

| Method | Description |
|--------|-------------|
| `language(Language\|string)` | Syntax mode |
| `darkTheme()` / `lightTheme()` | Editor theme |
| `readonly()` | Read-only mode |
