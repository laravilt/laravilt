---
title: Split
description: Two-pane layout with start and end content.
order: 5
---

# Split

A two-pane layout, for example main content with a sidebar.

```php
use Laravilt\Forms\Components\Textarea;
use Laravilt\Forms\Components\TextInput;
use Laravilt\Schemas\Components\Split;

Split::make('main')
    ->fromBreakpoint('lg')            // stacked below lg
    ->startColumnSpan('md:col-span-8')
    ->endColumnSpan('md:col-span-4')
    ->startSchema([
        TextInput::make('title'),
        Textarea::make('content'),
    ])
    ->endSchema([
        TextInput::make('status'),
    ]);
```

`leftSchema()` and `rightSchema()` are aliases for `startSchema()` and `endSchema()`.

The panel's schema renderer maps `split` on both stacks, so a Split works inside resource forms. Both panes render their schema like any other content. The standalone `InfoList` component only lays out Section, Grid and Tabs, so use those for infolist layouts.

## API reference

| Method | Description |
|--------|-------------|
| `make(string)` | Create (name required) |
| `fromBreakpoint(string)` | Breakpoint where the panes sit side by side (default `md`) |
| `startSchema(array)` / `endSchema(array)` | Pane content |
| `leftSchema(array)` / `rightSchema(array)` | Aliases |
| `startColumnSpan(string\|int)` / `endColumnSpan(string\|int)` | Pane widths (default `md:col-span-6`) |
