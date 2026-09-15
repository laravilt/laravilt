---
title: BulkActionGroup
description: Group bulk actions into a single dropdown.
order: 2
---

# BulkActionGroup

```php
use Laravilt\Actions\BulkAction;
use Laravilt\Actions\BulkActionGroup;
use Laravilt\Actions\DeleteBulkAction;

BulkActionGroup::make([
    BulkAction::make('publish')
        ->icon('Globe')
        ->action(fn ($records) => $records->each->publish()),
    BulkAction::make('unpublish')
        ->icon('EyeOff')
        ->action(fn ($records) => $records->each->unpublish()),
    DeleteBulkAction::make(),
])
    ->label('Bulk actions')
    ->icon('MoreHorizontal')
    ->color('gray');
```

## In a resource table

```php
use Laravilt\Actions\BulkActionGroup;
use Laravilt\Actions\DeleteBulkAction;
use Laravilt\Tables\Table;

public static function table(Table $table): Table
{
    return $table
        ->columns([...])
        ->toolbarActions([
            BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
        ]);
}
```

## API reference

| Method | Description |
|--------|-------------|
| `make(array $actions)` | Create the group |
| `label()`, `icon()`, `color()` | Dropdown trigger appearance |
