---
title: TextColumn
description: Display text with badges, dates, money, numbers, icons, and summaries.
order: 1
---

# TextColumn

The most common column. It displays the attribute as text and supports extensive formatting.

```php
use Laravilt\Tables\Columns\TextColumn;

TextColumn::make('name')
    ->searchable()
    ->sortable();
```

## Badges

```php
TextColumn::make('status')
    ->badge()
    ->color(fn (string $state) => match ($state) {
        'active' => 'success',
        'pending' => 'warning',
        default => 'secondary',
    });
```

The color closure receives `$state` and `$record`.

## Dates

```php
TextColumn::make('created_at')->date('M d, Y');
TextColumn::make('published_at')->dateTime('Y-m-d H:i');
TextColumn::make('updated_at')->since(); // "3 hours ago"
```

## Money and numbers

```php
TextColumn::make('price')->money('USD');
TextColumn::make('price_cents')->money('EUR', divideBy: 100);
TextColumn::make('views')->numeric(decimalPlaces: 0, locale: 'en');
```

## Copy, limit, and wrap

```php
TextColumn::make('api_key')
    ->copyable()
    ->copyMessage('Copied!')
    ->copyMessageDuration(1500);

TextColumn::make('body')->limit(50)->wrap();
```

## Icons, weight, and HTML

```php
TextColumn::make('email')
    ->icon('Mail')
    ->iconPosition('after')
    ->weight('bold');

TextColumn::make('bio')->html();
```

## Lists and relationship counts

```php
TextColumn::make('tags')->separator(',')->bulleted();

TextColumn::make('comments_count')->counts('comments');
```

## Summaries

```php
use Laravilt\Tables\Columns\Summarizers\Average;
use Laravilt\Tables\Columns\Summarizers\Count;
use Laravilt\Tables\Columns\Summarizers\Sum;

TextColumn::make('total')
    ->money('USD')
    ->summarize([
        Sum::make()->label('Total')->money(),
        Average::make()->precision(2),
        Count::make(),
    ]);
```

## API reference

| Method | Description |
|--------|-------------|
| `badge()` | Render as a badge |
| `color()` | Badge/text color (string or closure) |
| `date()`, `dateTime()`, `since()` | Date formatting |
| `money()`, `numeric()` | Number formatting |
| `copyable()`, `copyMessage()`, `copyMessageDuration()` | Copy to clipboard |
| `limit()`, `wrap()` | Truncate or wrap text |
| `icon()`, `iconPosition()` | Icon before/after the text |
| `weight()` | Font weight |
| `html()` | Render the value as HTML |
| `separator()`, `listWithLineBreaks()`, `bulleted()` | List display |
| `counts()` | Show a relationship count |
| `summarize()` | Add `Sum`, `Average`, or `Count` summaries |

See [Columns](README.md) for options shared by all columns.
