---
title: Section
description: Group components under a heading with description, icon, columns and collapse.
order: 1
---

# Section

Groups related components under a heading.

## Basic usage

```php
use Laravilt\Forms\Components\TextInput;
use Laravilt\Schemas\Components\Section;

Section::make('User Information')   // the name becomes the heading
    ->description('How users can reach you')
    ->icon('User')
    ->schema([
        TextInput::make('name'),
        TextInput::make('email'),
    ]);

Section::make()->schema([/* ... */]); // no heading
```

## Collapsible

```php
Section::make('Advanced Options')
    ->collapsible()
    ->collapsed()      // start collapsed
    ->schema([/* ... */]);
```

## Columns

```php
Section::make('Address')
    ->columns(2)
    ->schema([/* ... */]);

Section::make('Details')
    ->columns(['default' => 1, 'sm' => 2, 'lg' => 3])
    ->schema([/* ... */]);
```

## API reference

| Method | Description |
|--------|-------------|
| `make(?string)` | Create. The name is used as the heading |
| `heading(string\|Closure)` | Set the heading |
| `description(string\|Closure)` | Text under the heading |
| `icon(string\|Closure)` | Lucide icon |
| `columns(int\|array)` | Column layout |
| `collapsible(bool)` / `collapsed(bool)` | Collapse behaviour |
| `schema(array)` | Child components |

## Related

- [Grid](grid.md)
- [Tabs](tabs.md)
