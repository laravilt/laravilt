---
title: BulkAction
description: Build custom actions that run on multiple selected records.
order: 1
---

# BulkAction

Name the first closure parameter `$records` to receive the selected models as a collection, or `$ids` for just their keys. `$data` holds modal form values.

```php
use Laravilt\Actions\BulkAction;

BulkAction::make('approve')
    ->label('Approve selected')
    ->icon('CheckCircle')
    ->color('success')
    ->action(function ($records) {
        $records->each->update(['status' => 'approved']);
    });
```

`BulkAction` requires confirmation by default. Customize the modal with `modalHeading()` and `modalDescription()`, or turn it off with `requiresConfirmation(false)`.

## With a form

```php
use Laravilt\Forms\Components\Select;

BulkAction::make('changeStatus')
    ->form([
        Select::make('status')
            ->options([
                'pending' => 'Pending',
                'approved' => 'Approved',
                'rejected' => 'Rejected',
            ])
            ->required(),
    ])
    ->action(function ($records, array $data) {
        $records->each->update(['status' => $data['status']]);
    });
```

## Deselect after completion

Custom bulk actions keep the selection by default. The built-in delete/restore bulk actions clear it.

```php
BulkAction::make('process')
    ->deselectRecordsAfterCompletion()
    ->action(fn ($ids) => ProcessRecords::dispatch($ids));
```

## API reference

| Method | Description |
|--------|-------------|
| `action(Closure)` | Handler receiving `$records` / `$ids` and `$data` |
| `form()` / `schema()` | Modal form |
| `requiresConfirmation()`, `modalHeading()`, `modalDescription()` | Confirmation |
| `deselectRecordsAfterCompletion()` | Clear selection when done (default `false`) |
| `label()`, `icon()`, `color()` | Appearance |
