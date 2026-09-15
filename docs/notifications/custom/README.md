---
title: Custom Notifications
description: Build reusable notifications and send Laravilt notifications from your own Laravel notification classes.
order: 3
---

# Custom Notifications

## Reusable builders

`Laravilt\Notifications\Notification` has a `final` constructor. Use it through `make()` or the status constructors, and wrap your common notifications in a small factory class:

```php
<?php

namespace App\Notifications;

use App\Models\Order;
use Laravilt\Notifications\Notification;

class OrderShipped
{
    public static function for(Order $order): Notification
    {
        return Notification::success()
            ->title('Order shipped')
            ->body("Order #{$order->id} is on its way.")
            ->icon('heroicon-o-truck')
            ->actions([
                ['name' => 'view', 'label' => 'View order', 'url' => route('orders.show', $order)],
            ]);
    }
}

// Usage
$notification = OrderShipped::for($order);
$notification->send();
$notification->sendToDatabase($order->customer);
```

## Using Laravel's notify()

`sendToDatabase()` is shorthand for `$user->notify(new DatabaseNotification($notification))`. You can call it directly, for example to add delay or queue options:

```php
use Laravilt\Notifications\DatabaseNotification;
use Laravilt\Notifications\Notification;

$user->notify(
    (new DatabaseNotification(
        Notification::warning()->title('Subscription expiring')
    ))->delay(now()->addMinutes(5))
);
```

## Your own Laravel notification class

To send through several channels (for example mail and database), write a normal Laravel notification. Store the array produced by `DatabaseNotification` so the notification center can render it:

```php
<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification as LaravelNotification;
use Laravilt\Notifications\DatabaseNotification;
use Laravilt\Notifications\Notification;

class InvoicePaid extends LaravelNotification
{
    public function __construct(public int $invoiceId) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->line("Invoice #{$this->invoiceId} was paid.");
    }

    public function toArray(object $notifiable): array
    {
        $message = Notification::success()->title("Invoice #{$this->invoiceId} paid");

        return (new DatabaseNotification($message))->toArray($notifiable);
    }

    public function databaseType(object $notifiable): string
    {
        return 'laravilt';
    }
}
```

## Related

- [Notification Types](../types/README.md)
- [Actions](../features/actions.md)
