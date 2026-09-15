---
title: DateTimePicker
description: Combined date and time selection.
order: 2
---

# DateTimePicker

Combined date and time selection.

## Basic usage

```php
use Laravilt\Forms\Components\DateTimePicker;

DateTimePicker::make('scheduled_at')
    ->label('Schedule');
```

## Options

```php
DateTimePicker::make('meeting_at')
    ->step(15)                         // minute interval
    ->withSeconds()
    ->format24Hour()
    ->minDateTime(now()->toDateTimeString())
    ->maxDateTime(now()->addMonth()->toDateTimeString())
    ->timezone('America/New_York');
```

## API reference

| Method | Description |
|--------|-------------|
| `step(int)` | Minute interval |
| `withSeconds(bool)` | Show seconds |
| `format24Hour(bool)` | 24-hour clock |
| `minDateTime(string)` / `maxDateTime(string)` | Bounds |
| `timezone(string)` | Timezone |

For finer control over formats, use [DatePicker](date-picker.md) with `->time()`.
