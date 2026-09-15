---
title: Fixed Actions
description: Keep the row actions column pinned while scrolling horizontally.
order: 6
---

# Fixed Actions

On wide tables, `fixActions()` keeps the row actions column pinned while the table scrolls horizontally.

```php
use Laravilt\Actions\DeleteAction;
use Laravilt\Actions\EditAction;
use Laravilt\Actions\ViewAction;

$table
    ->fixActions()
    ->recordActions([
        ViewAction::make(),
        EditAction::make(),
        DeleteAction::make(),
    ]);
```

## API reference

| Method | Description |
|--------|-------------|
| `fixActions(bool $condition = true)` | Pin the actions column |
