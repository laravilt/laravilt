---
title: Database Notifications
description: Persistent notifications shown in the panel notification center.
order: 2
---

# Database Notifications

Database notifications use Laravel's `database` channel and appear in the panel's notification center, where users can mark them as read or delete them.

## Setup

1. Enable the notification center on the panel:

    ```php
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->databaseNotifications();
    }
    ```

    The installer adds this for you when you pick the `database-notifications` feature.

2. Make sure the `notifications` table exists:

    ```bash
    php artisan make:notifications-table
    php artisan migrate
    ```

3. The user model needs Laravel's `Notifiable` trait.

## Sending

```php
use Laravilt\Notifications\Notification;

Notification::info()
    ->title('New comment')
    ->body('John commented on your post.')
    ->sendToDatabase($user);
```

`sendToDatabase()` wraps the notification in `Laravilt\Notifications\DatabaseNotification`, which implements `ShouldQueue`. With a queue driver other than `sync`, keep a worker running (`php artisan queue:work`).

### Multiple recipients

`sendToDatabase()` takes a single notifiable. Loop for many:

```php
$notification = Notification::danger()->title('System alert');

User::where('role', 'admin')->each(
    fn (User $admin) => $notification->sendToDatabase($admin)
);
```

## Polling

The notification center refreshes every `30s` by default:

```php
$panel
    ->databaseNotifications()
    ->databaseNotificationsPolling('60s'); // or null to disable
```

## Routes

With `databaseNotifications()` enabled, the panel registers JSON endpoints under `/{panel}/notifications`:

```
GET     /                 List notifications
GET     /unread           Unread notifications
POST    /{id}/read        Mark one as read
POST    /read-all         Mark all as read
DELETE  /{id}             Delete one
DELETE  /                 Delete all
```

## Querying

These are standard Laravel notifications:

```php
$user->notifications;
$user->unreadNotifications;
$user->unreadNotifications->markAsRead();
```

## Related

- [Toast Notifications](toast.md)
- [Configuration](../features/configuration.md)
