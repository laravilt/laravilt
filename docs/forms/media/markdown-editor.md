---
title: MarkdownEditor
description: Markdown editor with toolbar, preview and file attachments.
order: 3
---

# MarkdownEditor

A Markdown editor with a toolbar and a live preview rendered by markdown-it.

```php
use Laravilt\Forms\Components\MarkdownEditor;

MarkdownEditor::make('readme')
    ->toolbarButtons(['bold', 'italic', 'link', 'heading', 'bulletList', 'orderedList', 'codeBlock'])
    ->preview()
    ->fileAttachments()
    ->fileAttachmentsDisk('public')
    ->fileAttachmentsDirectory('docs')
    ->showWordCount();
```

## API reference

| Method | Description |
|--------|-------------|
| `toolbarButtons(array)` | Visible toolbar buttons |
| `disableAllToolbarButtons()` | Hide the toolbar |
| `preview(bool)` | Enable the preview |
| `fileAttachments(bool)` | Allow attachments |
| `fileAttachmentsDisk()` / `fileAttachmentsDirectory()` | Attachment storage |
| `fileAttachmentsAcceptedFileTypes()` / `fileAttachmentsMaxSize()` | Attachment limits |
| `showCharacterCount(bool)` / `showWordCount(bool)` | Counters |
