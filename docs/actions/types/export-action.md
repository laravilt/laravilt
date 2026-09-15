---
title: ExportAction
description: Export records to XLSX or CSV with Laravel Excel.
order: 8
---

# ExportAction

`ExportAction` uses [Laravel Excel](https://docs.laravel-excel.com) (`maatwebsite/excel`).

```php
use App\Exports\ProductExporter;
use Laravilt\Actions\ExportAction;

ExportAction::make()
    ->exporter(ProductExporter::class)
    ->fileName('products');
```

Defaults: name `export`, label "Export", icon `download`, color `gray`, XLSX format.

## Generate an exporter

```bash
php artisan laravilt:exporter ProductExporter --model=Product
```

This creates `app/Exports/ProductExporter.php`, a Laravel Excel export class (`FromQuery`, `WithHeadings`, `WithMapping`). Edit `query()`, `headings()`, and `map()` to shape the file.

## Format

```php
ExportAction::make()->exporter(ProductExporter::class)->csv();
ExportAction::make()->exporter(ProductExporter::class)->xlsx();
```

## Without an exporter class

Without an exporter, the action exports the collection or query it receives, using the headings you give it:

```php
ExportAction::make()
    ->headings(['ID', 'Name', 'Email'])
    ->modifyQueryUsing(fn ($query) => $query->where('is_active', true));
```

## Queued exports

```php
ExportAction::make()
    ->exporter(ProductExporter::class)
    ->queue()
    ->disk('s3');
```

## API reference

| Method | Description |
|--------|-------------|
| `exporter(string)` | Laravel Excel export class |
| `fileName(string)` | Output file name |
| `xlsx()`, `csv()`, `writerType(string)` | Output format |
| `headings(array)`, `columns(array)` | Columns for class-less exports |
| `modifyQueryUsing(Closure)` | Adjust the query before exporting |
| `queue()`, `disk()`, `filePath()` | Queued exports |
