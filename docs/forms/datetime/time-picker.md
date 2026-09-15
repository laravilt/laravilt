---
title: TimePicker
description: Time-only selection field.
order: 3
---

# TimePicker

A time-only picker.

```php
use Laravilt\Forms\Components\TimePicker;

TimePicker::make('start_time')
    ->label('Start Time');

TimePicker::make('opening_time')
    ->format24Hour()
    ->step(30)
    ->minTime('08:00')
    ->maxTime('18:00')
    ->withSeconds(false);
```

## API reference

| Method | Description |
|--------|-------------|
| `format24Hour(bool)` | 24-hour clock |
| `step(int)` | Minute interval |
| `minTime(string)` / `maxTime(string)` | Bounds |
| `withSeconds(bool)` | Show seconds |
