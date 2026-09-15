---
title: Actions
description: Buttons that run server-side logic, open confirmation modals and forms, or navigate.
order: 5
---

# Actions

The `laravilt/actions` package provides `Laravilt\Actions\Action` and a set of prebuilt actions. An action is a button, link, or icon button. It can run a server-side closure, ask for confirmation, collect input in a modal form, or navigate to a URL. Actions appear in [table rows, bulk toolbars, and table headers](../tables/actions/README.md), and in page headers.

```php
use Laravilt\Actions\Action;
use Laravilt\Notifications\Notification;

Action::make('publish')
    ->label('Publish')
    ->icon('Send')
    ->color('success')
    ->requiresConfirmation()
    ->action(function ($record) {
        $record->update(['status' => 'published']);

        Notification::success()->title('Post published')->send();
    });
```

Closures get their arguments by parameter name: `$record` (the current record), `$records` or `$ids` (bulk selection), and `$data` (submitted form values).

## In this section

1. [Styling](styling.md): colors, icons, variants, sizes, and tooltips
2. [Confirmation](confirmation.md): confirmation modals, slide-overs, and password prompts
3. [Forms](forms.md): collect input or show details in a modal
4. [Notifications](notifications.md): feedback after an action runs
5. [Authorization](authorization.md): permissions, abilities, and visibility
6. [Action Types](types/README.md): View, Edit, Create, Delete, Restore, Force Delete, Replicate, Export, Import, and custom actions
7. [Bulk Actions](bulk/README.md): actions for multiple selected records

## Generating action classes

```bash
php artisan make:action PublishPost           # app/Actions/PublishPost.php
php artisan make:action PublishPost --modal   # with a confirmation modal
php artisan make:action PublishPost --form    # with a modal form
php artisan make:action PublishPost --auth    # with an authorization check
```

See [Custom Action](types/custom-action.md#reusable-action-classes) for how to use generated classes.
