---
title: Table Actions
description: Wire row, bulk, and header actions into a table.
order: 3
---

# Table Actions

A table has three places for actions. The action classes themselves are documented in [Actions](../../actions/README.md).

| Method | Where it renders | Page |
|--------|------------------|------|
| `recordActions()` | Each row | [Row Actions](row-actions.md) |
| `bulkActions()` / `toolbarActions()` | When rows are selected | [Bulk Actions](bulk-actions.md) |
| `headerActions()` | Above the table | [Header Actions](header-actions.md) |

```php
use Laravilt\Actions\BulkActionGroup;
use Laravilt\Actions\CreateAction;
use Laravilt\Actions\DeleteAction;
use Laravilt\Actions\DeleteBulkAction;
use Laravilt\Actions\EditAction;
use Laravilt\Actions\ViewAction;

$table
    ->headerActions([
        CreateAction::make(),
    ])
    ->recordActions([
        ViewAction::make(),
        EditAction::make(),
        DeleteAction::make(),
    ])
    ->toolbarActions([
        BulkActionGroup::make([
            DeleteBulkAction::make(),
        ]),
    ]);
```

To keep the actions column visible while scrolling horizontally, see [Fixed Actions](../features/fixed-actions.md).
