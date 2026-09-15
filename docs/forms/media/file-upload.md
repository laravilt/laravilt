---
title: FileUpload
description: File and image uploads with restrictions, image editing, storage options and Spatie Media Library.
order: 1
---

# FileUpload

File and image uploads, powered by FilePond.

## Basic usage

```php
use Laravilt\Forms\Components\FileUpload;

FileUpload::make('attachment')
    ->label('Attachment');
```

## Restrictions

```php
FileUpload::make('document')
    ->acceptedFileTypes(['application/pdf', '.docx'])
    ->maxSize(5120) // KB
    ->minSize(100);
```

## Multiple files

```php
FileUpload::make('attachments')
    ->multiple()
    ->minFiles(1)
    ->maxFiles(5)
    ->reorderable()
    ->downloadable()
    ->openable();
```

## Images

```php
FileUpload::make('photo')
    ->image()
    ->imagePreviewHeight('250')
    ->imageResizeTargetWidth('800')
    ->imageResizeTargetHeight('600');

FileUpload::make('avatar')
    ->avatar()
    ->imageEditor()
    ->imageCropAspectRatio('1:1')
    ->circleCropper();
```

## Storage

```php
FileUpload::make('file')
    ->disk('s3')
    ->directory('uploads')
    ->visibility('private')
    ->preserveFilenames();
```

## Spatie Media Library

Install `spatie/laravel-medialibrary`, then name the collection:

```php
FileUpload::make('images')
    ->collection('gallery')
    ->multiple();
```

## API reference

| Method | Description |
|--------|-------------|
| `acceptedFileTypes(array)` | Allowed MIME types or extensions |
| `maxSize()` / `minSize()` | Size limits in KB |
| `multiple(bool)` / `minFiles()` / `maxFiles()` | Multiple files |
| `image(bool)` | Images only |
| `avatar()` | Circular avatar layout |
| `imageEditor(bool)` / `imageEditorAspectRatios(array)` | Built-in image editor |
| `imageCropAspectRatio()` / `circleCropper()` | Cropping |
| `imageResizeTargetWidth()` / `imageResizeTargetHeight()` / `imageResizeMode()` | Resizing |
| `disk()` / `directory()` / `visibility()` | Storage |
| `preserveFilenames(bool)` / `storeFileNamesIn()` | File names |
| `reorderable()` / `downloadable()` / `openable()` / `deletable()` / `previewable()` | UI actions |
| `collection(?string)` | Spatie Media Library collection |
| `maxParallelUploads(int)` | Upload concurrency |

## Related

- [RichEditor](rich-editor.md)
