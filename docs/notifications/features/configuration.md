---
title: Configuration
description: Config file and panel options for notifications.
order: 2
---

# Configuration

## Config file

`config/laravilt-notifications.php` is intentionally small:

```php
return [
    'enabled' => env('LARAVILT_NOTIFICATIONS_ENABLED', true),
];
```

Publish it with `php artisan notifications:install` (add `--force` to overwrite an existing copy).

## Panel options

The notification center is configured on the panel:

| Method | Default | Description |
|--------|---------|-------------|
| `databaseNotifications(bool $condition = true)` | off | Show the notification center and register its routes |
| `databaseNotificationsPolling(string\|Closure\|null $interval)` | `'30s'` | How often the center refreshes. `null` disables polling. |
| `apiNotifications(bool $condition = true)` | off | Register the `/{panel}/notifications` JSON routes without the UI |

```php
$panel
    ->databaseNotifications()
    ->databaseNotificationsPolling('15s');
```

## Per-notification options

Duration, position, persistence and dismissing are set on each notification. See [Toast Notifications](../types/toast.md):

```php
Notification::info()
    ->title('Heads up')
    ->duration(8000)          // default 3000 ms
    ->position('top-center')
    ->send();
```

## Related

- [Database Notifications](../types/database.md)
- [Actions](actions.md)
