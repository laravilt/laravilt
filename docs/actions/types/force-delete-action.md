---
title: ForceDeleteAction
description: Permanently delete a soft-deleted record.
order: 6
---

# ForceDeleteAction

```php
use Laravilt\Actions\ForceDeleteAction;

ForceDeleteAction::make();
```

Defaults: label "Force delete", icon `Trash2`, color `destructive`, confirmation required. It's visible only for trashed records and can't be undone. The model must use `SoftDeletes`.

## Customizing

```php
ForceDeleteAction::make()
    ->modalHeading('Permanently delete')
    ->modalDescription('This action cannot be undone.')
    ->modalSubmitActionLabel('Delete permanently');
```

## Authorization

```php
ForceDeleteAction::make()->can('force_delete_post');
ForceDeleteAction::make()->authorize(fn ($record) => auth()->user()->can('forceDelete', $record));
```
