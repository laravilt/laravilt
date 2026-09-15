---
title: ForceDeleteBulkAction
description: Permanently delete all selected records.
order: 5
---

# ForceDeleteBulkAction

```php
use Laravilt\Actions\ForceDeleteBulkAction;

ForceDeleteBulkAction::make();
```

Defaults: label "Force delete", icon `Trash2`, color `destructive`, confirmation required, clears the selection afterwards. It calls `forceDelete()` on the selected records, including trashed ones. This can't be undone. The model must use `SoftDeletes`.

## Customizing

```php
use App\Models\Post;

ForceDeleteBulkAction::make()
    ->model(Post::class)
    ->modalHeading('Permanently delete selected')
    ->modalDescription('This action cannot be undone.')
    ->modalSubmitActionLabel('Delete permanently');
```

## API reference

| Method | Description |
|--------|-------------|
| `model(string)` | Model class |
| `resource(string)` | Resource class (for permission checks) |
| `deselectRecordsAfterCompletion(bool)` | Clear the selection (default `true`) |
| `modalHeading()`, `modalDescription()` | Confirmation text |
