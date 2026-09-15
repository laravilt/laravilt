---
title: Authorization
description: Control who can see and run actions with permissions, gates, and visibility rules.
order: 5
---

# Authorization

## Permissions

`can()` requires a named permission. It checks Spatie Permission when the user model supports it, and falls back to a Gate otherwise:

```php
use Laravilt\Actions\DeleteAction;

DeleteAction::make()->can('delete_post');
```

## Gate abilities and policies

`ability()` checks a Gate ability, passing the record when there is one, so policy methods work:

```php
use Laravilt\Actions\EditAction;

EditAction::make()->ability('update'); // Gate::allows('update', $record)
```

## Custom checks

`authorize()` takes a closure that receives the record:

```php
use Laravilt\Actions\Action;

Action::make('publish')
    ->authorize(fn ($record) => auth()->user()->can('publish', $record))
    ->action(fn ($record) => $record->publish());
```

Authorization is checked again on the server when the action runs. Unauthorized requests get a 403. Users with the super-admin role (`laravilt-users.super_admin.role`, default `super_admin`) bypass these checks.

## Visibility

`visible()` and `hidden()` accept a boolean or a closure. Name the parameter `$record` to evaluate it per row:

```php
Action::make('restore')->visible(fn ($record) => $record->trashed());
Action::make('archive')->hidden(fn ($record) => $record->archived_at !== null);
```

## Built-in behavior

Prebuilt actions check the resource's permissions (`canCreate`, `canDelete`, and so on) and handle soft deletes automatically:

| Action | Hidden when |
|--------|-------------|
| `EditAction`, `DeleteAction` | The record is trashed, or the user lacks permission |
| `RestoreAction`, `ForceDeleteAction` | The record is **not** trashed, or the user lacks permission |
| `CreateAction`, `ReplicateAction` | The user lacks permission |

## API reference

| Method | Description |
|--------|-------------|
| `can(string $permission)` | Require a permission |
| `ability(string $ability)` | Require a Gate ability (record-aware) |
| `authorize(Closure)` | Custom check: `fn ($record) => bool` |
| `visible()`, `hidden()` | Show or hide the action |
