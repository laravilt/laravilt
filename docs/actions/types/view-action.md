---
title: ViewAction
description: Link to a record's view page.
order: 1
---

# ViewAction

```php
use Laravilt\Actions\ViewAction;

ViewAction::make();
```

Defaults: label "View", icon `Eye`, color `secondary`, `GET` navigation. Inside a resource, the URL resolves to the resource's view page.

## Customizing

```php
ViewAction::make()
    ->label('Details')
    ->icon('FileText')
    ->url(fn ($record) => route('posts.show', $record))
    ->openUrlInNewTab()
    ->visible(fn ($record) => $record->is_published);
```

## Authorization

```php
ViewAction::make()->can('view_post');
ViewAction::make()->authorize(fn ($record) => auth()->user()->can('view', $record));
```

See [Authorization](../authorization.md).
