---
title: Actions
description: Add buttons to toast and database notifications.
order: 1
---

# Notification Actions

`actions(array $actions)` attaches buttons to a notification. Each action is a plain array, which is serialized into the session (toasts) or the database (notification center).

```php
use Laravilt\Notifications\Notification;

Notification::info()
    ->title('New order')
    ->body('Order #12345 needs processing.')
    ->actions([
        [
            'name' => 'view',
            'label' => 'View order',
            'url' => route('orders.show', 12345),
        ],
    ])
    ->sendToDatabase($user);
```

## Action keys

| Key | Description |
|-----|-------------|
| `name` | Unique key for the button |
| `label` | Button text |
| `url` | Link opened when the button is clicked |
| `color` | Button color. `danger` renders a destructive button. |
| `variant` | Optional frontend variant, such as `destructive` |

## Multiple actions

```php
Notification::warning()
    ->title('Team invitation')
    ->body('You were invited to join Team Alpha.')
    ->actions([
        ['name' => 'accept', 'label' => 'Accept', 'url' => url('/invitations/123/accept')],
        ['name' => 'decline', 'label' => 'Decline', 'url' => url('/invitations/123/decline'), 'color' => 'danger'],
    ])
    ->sendToDatabase($user);
```

Actions are links. To run server-side code, point the URL at a route or controller that does the work.

## Extra data

Use `data(array $data)` to send extra values that your own frontend code can read:

```php
Notification::info()
    ->title('Report ready')
    ->data(['report_id' => $report->id])
    ->sendToDatabase($user);
```

## Related

- [Toast Notifications](../types/toast.md)
- [Database Notifications](../types/database.md)
