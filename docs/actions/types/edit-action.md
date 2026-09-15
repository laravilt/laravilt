---
title: EditAction
description: Link to a record's edit page.
order: 2
---

# EditAction

```php
use Laravilt\Actions\EditAction;

EditAction::make();
```

Defaults: label "Edit", icon `Pencil`, color `warning`, `GET` navigation. Inside a resource, the URL resolves to the edit page. The action is hidden for trashed records and for users without update permission.

## Customizing

```php
EditAction::make()
    ->label('Modify')
    ->icon('SquarePen')
    ->url(fn ($record) => route('posts.edit', $record))
    ->hidden(fn ($record) => $record->is_locked);
```

## Authorization

```php
EditAction::make()->can('update_post');
EditAction::make()->ability('update');
```

See [Authorization](../authorization.md).
