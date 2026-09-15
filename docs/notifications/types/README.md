---
title: Notification Types
description: Choose between toast messages and persistent database notifications.
order: 1
---

# Notification Types

The same `Notification` object can be delivered in two ways.

| Type | Method | Lifetime |
|------|--------|----------|
| [Toast](toast.md) | `send()` | Flashed to the session and shown once on the next page load |
| [Database](database.md) | `sendToDatabase($notifiable)` | Stored in the `notifications` table until the user deletes it |

You can send both from one object:

```php
use Laravilt\Notifications\Notification;

$notification = Notification::success()
    ->title('Export finished')
    ->body('Your CSV is ready to download.');

$notification->send();                 // toast now
$notification->sendToDatabase($user);  // keep it in the notification center
```

`sendToDatabase()` returns `void`, so call `send()` first or keep a reference as shown above.

## Statuses

| Constructor | Status | Default icon |
|-------------|--------|--------------|
| `Notification::success()` | `success` | `heroicon-o-check-circle` |
| `Notification::danger()` | `danger` | `heroicon-o-x-circle` |
| `Notification::warning()` | `warning` | `heroicon-o-exclamation-triangle` |
| `Notification::info()` | `info` | `heroicon-o-information-circle` |

`Notification::make()` starts a notification with status `info` and no icon. Set the status yourself with `->status('success')->color('success')`.
