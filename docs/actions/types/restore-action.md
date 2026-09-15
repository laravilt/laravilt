---
title: RestoreAction
description: Restore a soft-deleted record.
order: 5
---

# RestoreAction

```php
use Laravilt\Actions\RestoreAction;

RestoreAction::make();
```

Defaults: label "Restore", icon `RotateCcw`, color `success`, confirmation required. It's visible only for trashed records, so pair it with a [TrashedFilter](../../tables/filters/trashed-filter.md). The model must use `SoftDeletes`.

## Customizing

```php
RestoreAction::make()
    ->modalHeading('Restore record')
    ->modalDescription('This will restore the deleted record.')
    ->modalSubmitActionLabel('Restore');
```

## Authorization

```php
RestoreAction::make()->can('restore_post');
RestoreAction::make()->authorize(fn ($record) => auth()->user()->can('restore', $record));
```
