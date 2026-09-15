---
title: Row Actions
description: Add per-record actions to each table row.
order: 1
---

# Row Actions

Row actions are passed to `recordActions()`. Closures receive the row's `$record`.

```php
use Laravilt\Actions\DeleteAction;
use Laravilt\Actions\EditAction;
use Laravilt\Actions\ViewAction;

$table->recordActions([
    ViewAction::make(),
    EditAction::make(),
    DeleteAction::make(),
]);
```

In a resource, View and Edit resolve their URLs automatically, and a row click opens the first action's URL. Change that with `$table->recordUrl(fn ($record) => ...)` or `$table->disableRecordUrlFromFirstAction()`.

## Custom row action

```php
use Laravilt\Actions\Action;
use Laravilt\Notifications\Notification;

Action::make('publish')
    ->icon('Send')
    ->color('success')
    ->requiresConfirmation()
    ->visible(fn ($record) => $record->status !== 'published')
    ->action(function ($record) {
        $record->update(['status' => 'published']);

        Notification::success()->title('Published')->send();
    });
```

Name the closure parameter `$record` for visibility checks that need the row.

## Next

- [Action types](../../actions/types/README.md): View, Edit, Delete, Replicate, and more
- [Confirmation](../../actions/confirmation.md) and [Forms](../../actions/forms.md)
