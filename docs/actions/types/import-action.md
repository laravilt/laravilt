---
title: ImportAction
description: Import records from XLSX or CSV files with Laravel Excel.
order: 9
---

# ImportAction

`ImportAction` opens a modal with a file upload and runs a [Laravel Excel](https://docs.laravel-excel.com) import class.

```php
use App\Imports\ProductImporter;
use Laravilt\Actions\ImportAction;

ImportAction::make()
    ->importer(ProductImporter::class);
```

Defaults: name `import`, label "Import", icon `upload`, color `gray`. Accepted file types are `.xls`, `.xlsx`, and `.csv`.

## Generate an importer

```bash
php artisan laravilt:importer ProductImporter --model=Product
```

This creates `app/Imports/ProductImporter.php`, a Laravel Excel import class (`ToModel`, `WithHeadingRow`, `WithValidation`, `SkipsEmptyRows`). Map each row in `model()` and validate it in `rules()`.

## File type

```php
ImportAction::make()->importer(ProductImporter::class)->csv();

ImportAction::make()
    ->importer(ProductImporter::class)
    ->acceptedFileTypes(['text/csv']);
```

## Hooks

Both callbacks receive the uploaded file:

```php
use Laravilt\Notifications\Notification;

ImportAction::make()
    ->importer(ProductImporter::class)
    ->beforeImport(fn ($file) => logger()->info('Import started'))
    ->afterImport(function ($file) {
        Notification::success()->title('Import completed')->send();
    });
```

## Queued imports

```php
ImportAction::make()
    ->importer(ProductImporter::class)
    ->queue()
    ->disk('s3');
```

## API reference

| Method | Description |
|--------|-------------|
| `importer(string)` | Laravel Excel import class |
| `xlsx()`, `csv()`, `readerType(string)` | Input format |
| `acceptedFileTypes(array)` | Allowed MIME types |
| `beforeImport(Closure)`, `afterImport(Closure)` | Hooks |
| `queue()`, `disk()`, `chunkSize(int)` | Queued imports |
