---
title: ReplicateAction
description: Duplicate a record with Eloquent's replicate().
order: 7
---

# ReplicateAction

```php
use Laravilt\Actions\ReplicateAction;

ReplicateAction::make();
```

Defaults: label "Replicate", icon `Copy`, color `gray`, confirmation required. Hidden when the user lacks replicate permission.

## Exclude attributes

```php
ReplicateAction::make()
    ->excludeAttributes(['slug', 'published_at', 'views_count']);
```

## Hooks

Both callbacks receive the replica and the original record:

```php
use Illuminate\Support\Str;

ReplicateAction::make()
    ->beforeReplicaSaved(function ($replica, $original) {
        $replica->title = $original->title.' (Copy)';
        $replica->slug = Str::slug($replica->title);
    })
    ->afterReplicaSaved(function ($replica, $original) {
        $replica->tags()->sync($original->tags->pluck('id'));
    });
```

## Redirect

```php
ReplicateAction::make()
    ->successRedirectUrl(fn ($record) => route('posts.edit', $record));
```

## API reference

| Method | Description |
|--------|-------------|
| `excludeAttributes(array)` | Attributes not copied |
| `beforeReplicaSaved(Closure)` | Modify the replica before saving |
| `afterReplicaSaved(Closure)` | Run after saving |
| `successRedirectUrl(Closure)` | URL to open afterwards |
