---
title: Bulk Actions
description: Run actions on the selected rows of a table.
order: 2
---

# Bulk Actions

Selecting rows reveals bulk actions. Register them with `bulkActions()`, or with `toolbarActions()` wrapped in a `BulkActionGroup`, which is what the resource generator produces.

```php
use Laravilt\Actions\BulkActionGroup;
use Laravilt\Actions\DeleteBulkAction;
use Laravilt\Actions\ForceDeleteBulkAction;
use Laravilt\Actions\RestoreBulkAction;

$table->toolbarActions([
    BulkActionGroup::make([
        DeleteBulkAction::make(),
        RestoreBulkAction::make(),
        ForceDeleteBulkAction::make(),
    ]),
]);
```

## Custom bulk action

Name the first closure parameter `$records` to receive the selected models as a collection, or `$ids` to receive only their keys. A `$data` parameter receives the modal form values.

```php
use Laravilt\Actions\BulkAction;
use Laravilt\Forms\Components\Select;

$table->bulkActions([
    BulkAction::make('assignCategory')
        ->icon('Tag')
        ->form([
            Select::make('category_id')
                ->options(fn () => Category::pluck('name', 'id')->all())
                ->required(),
        ])
        ->deselectRecordsAfterCompletion()
        ->action(function ($records, array $data) {
            $records->each->update(['category_id' => $data['category_id']]);
        }),
]);
```

Bulk actions require confirmation by default. See [BulkAction](../../actions/bulk/bulk-action.md) and the other [bulk action types](../../actions/bulk/README.md).
