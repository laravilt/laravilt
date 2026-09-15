---
title: RichEditor
description: WYSIWYG HTML editor built on Tiptap.
order: 2
---

# RichEditor

A WYSIWYG HTML editor built on Tiptap.

## Basic usage

```php
use Laravilt\Forms\Components\RichEditor;

RichEditor::make('content')
    ->label('Content');
```

## Toolbar and size

```php
RichEditor::make('body')
    ->toolbarButtons(['bold', 'italic', 'underline', 'link', 'bulletList', 'orderedList', 'blockquote'])
    ->minHeight(200)
    ->maxHeight(500)
    ->showWordCount();
```

## Attachments

```php
RichEditor::make('article')
    ->fileAttachmentsDisk('public')
    ->fileAttachmentsDirectory('articles')
    ->fileAttachmentsAcceptedFileTypes(['image/png', 'image/jpeg'])
    ->fileAttachmentsMaxSize(2048);
```

## API reference

| Method | Description |
|--------|-------------|
| `toolbarButtons(array)` | Visible toolbar buttons |
| `minHeight(?int)` / `maxHeight(?int)` | Editor height |
| `json(bool)` | Store Tiptap JSON instead of HTML |
| `textColors(array)` / `customTextColors(array)` | Text color palette |
| `floatingToolbars(array)` | Context toolbars |
| `fileAttachmentsDisk()` / `fileAttachmentsDirectory()` / `fileAttachmentsVisibility()` | Attachment storage |
| `fileAttachmentsAcceptedFileTypes()` / `fileAttachmentsMaxSize()` | Attachment limits |
| `customBlocks(array)` / `mergeTags(array)` | Custom content |
| `showCharacterCount(bool)` / `showWordCount(bool)` | Counters |
