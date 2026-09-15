---
title: DeleteAction
description: Delete a record after confirmation.
order: 4
---

# DeleteAction

```php
use Laravilt\Actions\DeleteAction;

DeleteAction::make();
```

Defaults: label "Delete", icon `Trash2`, color `destructive`, confirmation required. Inside a resource it deletes the record (a soft delete if the model uses `SoftDeletes`), shows a notification, and redirects to the list page. It's hidden for trashed records and for users without delete permission.

## Customizing

```php
DeleteAction::make()
    ->modalHeading('Delete post')
    ->modalDescription('This post will be moved to the trash.')
    ->modalSubmitActionLabel('Yes, delete it')
    ->icon('XCircle');
```

## Custom delete logic

A custom `action()` replaces the default behavior:

```php
DeleteAction::make()
    ->action(function ($record) {
        $record->update(['archived_at' => now()]);
    });
```

## Authorization

```php
DeleteAction::make()->can('delete_post');
DeleteAction::make()->authorize(fn ($record) => auth()->user()->can('delete', $record));
```

See also [RestoreAction](restore-action.md), [ForceDeleteAction](force-delete-action.md), and [DeleteBulkAction](../bulk/delete-bulk-action.md).
