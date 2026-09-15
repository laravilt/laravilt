---
title: Builder
description: Block-based content builder with typed blocks.
order: 2
---

# Builder

A block-based content builder. Each block type has its own fields.

## Basic usage

```php
use Laravilt\Forms\Components\Builder;
use Laravilt\Forms\Components\Builder\Block;
use Laravilt\Forms\Components\FileUpload;
use Laravilt\Forms\Components\TextInput;
use Laravilt\Forms\Components\Textarea;

Builder::make('content')
    ->blocks([
        Block::make('heading')
            ->label('Heading')
            ->icon('Heading')
            ->schema([
                TextInput::make('content')->required(),
            ]),
        Block::make('paragraph')
            ->label('Paragraph')
            ->icon('AlignLeft')
            ->schema([
                Textarea::make('content'),
            ]),
        Block::make('image')
            ->columns(2)
            ->schema([
                FileUpload::make('url')->image(),
                TextInput::make('alt'),
            ]),
    ]);
```

## Behaviour

```php
Builder::make('page_content')
    ->blocks([/* ... */])
    ->reorderable()
    ->collapsible()
    ->cloneable()
    ->minItems(1)
    ->maxItems(20)
    ->addActionLabel('Add block')
    ->blockPickerColumns(3);
```

## API reference

| Method | Description |
|--------|-------------|
| `blocks(array)` | Available `Block` types |
| `addable()` / `deletable()` / `reorderable()` / `cloneable()` | Item actions |
| `reorderableWithButtons()` / `reorderableWithDragAndDrop()` | Reorder mode |
| `collapsible()` / `collapsed()` | Collapse items |
| `minItems(int)` / `maxItems(int)` | Item counts |
| `addActionLabel()` / `addActionAlignment()` | Add button |
| `blockNumbers()` / `blockIcons()` / `blockPreviews()` | Item display |
| `blockPickerColumns()` / `blockPickerWidth()` | Block picker layout |

`Block` supports `label()`, `icon()`, `schema()`, `columns()` and `collapsible()`.
