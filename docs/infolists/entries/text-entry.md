---
title: TextEntry
description: Display text with date, money, number, badge, HTML and markdown formatting.
order: 1
---

# TextEntry

Displays text with formatting options.

## Basic usage

```php
use Laravilt\Infolists\Entries\TextEntry;

TextEntry::make('name')->label('Full Name');
```

## Badge

```php
TextEntry::make('status')
    ->badge()
    ->color(fn (string $state): string => match ($state) {
        'active' => 'success',
        'pending' => 'warning',
        default => 'gray',
    });
```

## Dates and numbers

```php
TextEntry::make('created_at')->dateTime('M d, Y H:i');
TextEntry::make('published_at')->date();
TextEntry::make('updated_at')->since();

TextEntry::make('price')->money('USD');
TextEntry::make('views')->numeric(decimalPlaces: 0);
```

## Content

```php
TextEntry::make('content')->html();
TextEntry::make('readme')->markdown()->prose();
TextEntry::make('summary')->limit(100)->wrap();
TextEntry::make('tags')->separator(', ');
```

## Links, affixes and copy

```php
TextEntry::make('website')->url('https://example.com', openInNewTab: true);
TextEntry::make('weight')->suffix(' kg');
TextEntry::make('api_key')->copyable()->copyMessage('Copied!');
```

## API reference

| Method | Description |
|--------|-------------|
| `badge(bool)` | Render as a badge |
| `date(format)` / `dateTime(format)` / `since()` | Date formatting |
| `money(currency, divideBy)` | Currency |
| `numeric(decimalPlaces, decimalSeparator, thousandsSeparator, locale)` | Number format |
| `html()` / `markdown()` / `prose()` | Rich content |
| `limit(int)` / `wrap()` | Length and wrapping |
| `prefix(string)` / `suffix(string)` | Affixes |
| `weight(?string)` / `size(?string)` | Typography |
| `url(?string, openInNewTab)` / `openUrlInNewTab()` | Links |
| `copyable()` / `copyMessage(?string)` | Copy to clipboard |
| `separator(?string)` | Join array values |
| `strikethrough(bool)` | Strike through |
