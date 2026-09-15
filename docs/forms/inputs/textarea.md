---
title: Textarea
description: Multi-line text input with autosize and character or word counters.
order: 2
---

# Textarea

A multi-line text input.

## Basic usage

```php
use Laravilt\Forms\Components\Textarea;

Textarea::make('description')
    ->label('Description')
    ->rows(4);
```

## Autosize

```php
Textarea::make('notes')
    ->autosize()
    ->minRows(3)
    ->maxRows(10);
```

## Limits and counters

```php
Textarea::make('bio')
    ->minLength(50)
    ->maxLength(500)
    ->characterCount()
    ->wordCount();
```

## API reference

| Method | Description |
|--------|-------------|
| `rows(int)` | Visible rows |
| `minRows(int)` / `maxRows(int)` | Row bounds for autosize |
| `autosize(bool)` | Grow with content |
| `minLength(int)` / `maxLength(int)` | Length limits |
| `characterCount(bool)` | Show a character counter (alias: `showCharacterCount()`) |
| `wordCount(bool)` | Show a word counter (alias: `showWordCount()`) |
