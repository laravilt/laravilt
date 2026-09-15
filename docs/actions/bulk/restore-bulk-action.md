---
title: RestoreBulkAction
description: Restore all selected soft-deleted records.
order: 4
---

# RestoreBulkAction

```php
use Laravilt\Actions\RestoreBulkAction;

RestoreBulkAction::make();
```

Defaults: label "Restore", icon `RotateCcw`, color `success`, confirmation required, clears the selection afterwards. The model must use `SoftDeletes`. Pair it with a [TrashedFilter](../../tables/filters/trashed-filter.md).

## Customizing

```php
use App\Models\Post;

RestoreBulkAction::make()
    ->model(Post::class)
    ->modalHeading('Restore selected')
    ->modalSubmitActionLabel('Restore all');
```

## API reference

| Method | Description |
|--------|-------------|
| `model(string)` | Model class |
| `resource(string)` | Resource class (for permission checks) |
| `deselectRecordsAfterCompletion(bool)` | Clear the selection (default `true`) |
| `modalHeading()`, `modalDescription()` | Confirmation text |
