---
title: Notifications
description: Show success or failure feedback after an action runs.
order: 4
---

# Notifications

Send a toast from the action closure with `Laravilt\Notifications\Notification`. See [Notifications](../notifications/README.md) for all options.

```php
use Laravilt\Actions\Action;
use Laravilt\Notifications\Notification;

Action::make('publish')
    ->action(function ($record) {
        $record->publish();

        Notification::success()
            ->title('Post published')
            ->body("\"{$record->title}\" is now live.")
            ->send();
    });
```

## Failure feedback

```php
Action::make('process')
    ->action(function ($record) {
        if (! $record->canBeProcessed()) {
            Notification::danger()
                ->title('Cannot process this record')
                ->send();

            return;
        }

        $record->process();

        Notification::success()->title('Processed')->send();
    });
```

If the closure throws, the request fails and the error is reported back to the page.

## Bulk actions

```php
use Laravilt\Actions\BulkAction;

BulkAction::make('publish')
    ->action(function ($records) {
        $records->each->publish();

        Notification::success()
            ->title("{$records->count()} posts published")
            ->send();
    });
```

Built-in actions such as [DeleteAction](types/delete-action.md) and [CreateAction](types/create-action.md) send their own success notifications.
