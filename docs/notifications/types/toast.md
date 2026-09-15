---
title: Toast Notifications
description: Short-lived on-screen messages sent with send().
order: 1
---

# Toast Notifications

A toast is a short message that disappears on its own. `send()` flashes the notification to the session, and the panel shows it on the next response, so it also works after a redirect.

## Basic usage

```php
use Laravilt\Notifications\Notification;

Notification::success()
    ->title('Saved successfully')
    ->send();
```

## Body and icon

```php
Notification::success()
    ->title('File uploaded')
    ->body('report.pdf has been uploaded.')
    ->icon('heroicon-o-arrow-up-tray')
    ->send();
```

`icon(?string $icon, ?string $position = 'before')` replaces the status icon.

## Duration and persistence

Toasts stay for 3000 ms by default.

```php
Notification::info()
    ->title('Quick message')
    ->duration(1500)
    ->send();

// Stay until the user closes it
Notification::warning()
    ->title('Action required')
    ->persistent()
    ->send();
```

## Position and dismissing

```php
Notification::info()
    ->title('Heads up')
    ->position('bottom-right')
    ->dismissible()
    ->send();
```

## Methods

| Method | Description |
|--------|-------------|
| `Notification::make()` / `success()` / `danger()` / `warning()` / `info()` | Create a notification (static) |
| `title(?string)` | Title |
| `body(?string)` | Body text |
| `icon(?string $icon, ?string $position = 'before')` | Icon name |
| `color(?string)` | Color (`success`, `danger`, `warning`, `info`, ...) |
| `status(string)` | Status string |
| `duration(?int)` | Display time in milliseconds (default `3000`) |
| `persistent(bool $condition = true)` | Don't auto-dismiss |
| `dismissible(bool $condition = true)` | Show a close button |
| `position(?string)` | Toast position |
| `actions(array)` | Buttons (see [Actions](../features/actions.md)) |
| `data(array)` | Extra payload for your frontend |
| `send()` | Flash as a toast |

## Related

- [Database Notifications](database.md)
- [Actions](../features/actions.md)
