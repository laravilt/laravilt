---
title: TrashedFilter
description: Show, hide, or isolate soft-deleted records.
order: 3
---

# TrashedFilter

```php
use Laravilt\Tables\Filters\TrashedFilter;

TrashedFilter::make();
```

The filter is named `trashed` and has three states:

| Value | Query |
|-------|-------|
| `without` (default) | `withoutTrashed()`: active records only |
| `with` | `withTrashed()`: all records |
| `only` | `onlyTrashed()`: deleted records only |

The model must use `SoftDeletes`:

```php
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
}
```

Pair it with [RestoreAction](../../actions/types/restore-action.md), [ForceDeleteAction](../../actions/types/force-delete-action.md), and their [bulk versions](../../actions/bulk/README.md).
