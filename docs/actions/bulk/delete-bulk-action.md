---
title: DeleteBulkAction
description: Delete all selected records after confirmation.
order: 3
---

# DeleteBulkAction

```php
use Laravilt\Actions\DeleteBulkAction;

DeleteBulkAction::make();
```

Defaults: icon `Trash2`, color `destructive`, confirmation required, clears the selection afterwards, and shows the deleted count in a notification. Records are soft-deleted when the model uses `SoftDeletes`.

The table passes its model to the action automatically. Set it yourself when the table has no model:

```php
use App\Models\Post;

DeleteBulkAction::make()->model(Post::class);
```

## Customizing

```php
DeleteBulkAction::make()
    ->label('Remove selected')
    ->modalHeading('Delete selected')
    ->modalDescription('Are you sure you want to delete the selected records?')
    ->modalSubmitActionLabel('Delete all');
```

## API reference

| Method | Description |
|--------|-------------|
| `model(string)` | Model class |
| `resource(string)` | Resource class (for permission checks) |
| `deselectRecordsAfterCompletion(bool)` | Clear the selection (default `true`) |
| `modalHeading()`, `modalDescription()`, `modalSubmitActionLabel()` | Confirmation text |
