---
title: Custom Action
description: Build your own actions inline or as reusable classes.
order: 10
---

# Custom Action

```php
use Laravilt\Actions\Action;

Action::make('approve')
    ->label('Approve')
    ->icon('CheckCircle')
    ->color('success')
    ->requiresConfirmation()
    ->action(function ($record) {
        $record->update(['status' => 'approved']);
    });
```

## With a form

```php
use Laravilt\Forms\Components\Select;
use Laravilt\Forms\Components\Textarea;

Action::make('changeStatus')
    ->icon('RefreshCw')
    ->schema([
        Select::make('status')
            ->options(['pending' => 'Pending', 'approved' => 'Approved'])
            ->required(),
        Textarea::make('notes'),
    ])
    ->action(fn ($record, array $data) => $record->update($data));
```

## URL actions

An action with a URL navigates instead of running a closure:

```php
Action::make('report')
    ->icon('ExternalLink')
    ->url(fn ($record) => route('reports.show', $record))
    ->openUrlInNewTab();
```

## Closure arguments

Arguments are injected by parameter name:

| Parameter | Value |
|-----------|-------|
| `$record` | The current record |
| `$data` | Submitted modal form values |
| `$records` | Selected records, as a collection (bulk actions) |
| `$ids` | Selected record keys (bulk actions) |
| `Get $get`, `Set $set` | `Laravilt\Support\Utilities\Get` / `Set` for form data |

## Reusable action classes

Generate a class with `make:action`:

```bash
php artisan make:action ApprovePost          # plain
php artisan make:action ApprovePost --modal  # with confirmation modal
php artisan make:action ApprovePost --form   # with a modal form
```

The class goes in `app/Actions` and extends `Laravilt\Actions\Action`. Configure it in `setUp()` and wire your logic with `action()`:

```php
namespace App\Actions;

use Laravilt\Actions\Action;

class ApprovePost extends Action
{
    protected function setUp(): void
    {
        $this->name ??= 'approve';

        $this
            ->label('Approve')
            ->icon('CheckCircle')
            ->color('success')
            ->requiresConfirmation()
            ->action(fn ($record) => $record->update(['status' => 'approved']));
    }
}
```

```php
use App\Actions\ApprovePost;

$table->recordActions([ApprovePost::make()]);
```

> The generated stub includes a `handle()` method, but Laravilt doesn't call it automatically. Call it from your `action()` closure, or put the logic in the closure directly as shown above.

## API reference

| Method | Description |
|--------|-------------|
| `make(?string $name)` | Create the action |
| `action(Closure)` | Server-side handler |
| `url()`, `openUrlInNewTab()` | Navigate instead |
| `label()`, `icon()`, `color()` | See [Styling](../styling.md) |
| `requiresConfirmation()`, `modalHeading()`, `slideOver()` | See [Confirmation](../confirmation.md) |
| `schema()` / `form()` | See [Forms](../forms.md) |
| `can()`, `authorize()`, `visible()` | See [Authorization](../authorization.md) |
