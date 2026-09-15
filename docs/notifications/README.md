---
title: Notifications
description: Toast messages and a persistent database notification center for Laravilt panels.
order: 8
---

# Notifications

The `laravilt/notifications` package gives you one fluent `Notification` builder for two kinds of messages:

- **Toasts** are short-lived messages shown after the next request, such as "Saved successfully".
- **Database notifications** are stored with Laravel's notification system and shown in the panel's bell-icon notification center.

```php
use Laravilt\Notifications\Notification;

// Toast
Notification::success()
    ->title('Saved successfully')
    ->send();

// Notification center
Notification::info()
    ->title('New order')
    ->body('Order #12345 was placed.')
    ->sendToDatabase($user);
```

> `success()`, `danger()`, `warning()` and `info()` are **static constructors** that create a new notification. Call them first, then chain `title()` and the rest. Writing `Notification::make()->title('...')->success()` discards the title.

The panel renders notifications with its Vue 3 or React 19 components, so no frontend code is needed.

> React support requires Laravilt v1.1 or later.

## In this section

1. [Notification Types](types/README.md): [Toast](types/toast.md) and [Database](types/database.md)
2. [Features](features/README.md): [Actions](features/actions.md) and [Configuration](features/configuration.md)
3. [Custom Notifications](custom/README.md): reusable notification classes

## Installation

The package is installed with Laravilt. To reinstall or republish its files:

```bash
php artisan notifications:install [--force] [--without-assets] [--without-migrations] [--without-seeders]
```
