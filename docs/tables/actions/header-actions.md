---
title: Header Actions
description: Add actions above a table, such as create, import, and export.
order: 3
---

# Header Actions

Header actions render above the table and don't act on a specific record.

```php
use App\Exports\ProductExporter;
use App\Imports\ProductImporter;
use Laravilt\Actions\CreateAction;
use Laravilt\Actions\ExportAction;
use Laravilt\Actions\ImportAction;

$table->headerActions([
    CreateAction::make(),
    ExportAction::make()->exporter(ProductExporter::class),
    ImportAction::make()->importer(ProductImporter::class),
]);
```

`CreateAction` configures itself from the page: it links to the resource's create page, or opens a modal form on "manage records" (simple) resources.

## Custom header action

```php
use Laravilt\Actions\Action;

Action::make('docs')
    ->label('Help')
    ->icon('BookOpen')
    ->url('https://laravilt.com/docs', shouldOpenInNewTab: true);
```

See [CreateAction](../../actions/types/create-action.md), [ExportAction](../../actions/types/export-action.md), and [ImportAction](../../actions/types/import-action.md).
