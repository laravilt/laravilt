---
title: Date & Time
description: Date, date-time, time and date-range pickers.
order: 3
---

# Date & Time

Fields for picking dates and times. The calendars are built on reka-ui (Vue) or the equivalent shadcn/ui primitives (React), with `@internationalized/date`. Everything ships with the package, so there is nothing extra to install.

| Component | Description |
|-----------|-------------|
| [DatePicker](date-picker.md) | Date selection with a calendar popup |
| [DateTimePicker](date-time-picker.md) | Date and time |
| [TimePicker](time-picker.md) | Time only |
| [DateRangePicker](date-range-picker.md) | Start and end date |

```php
use Laravilt\Forms\Components\DatePicker;
use Laravilt\Forms\Components\DateTimePicker;
use Laravilt\Forms\Components\TimePicker;

DatePicker::make('birth_date')->required();

DateTimePicker::make('published_at');

TimePicker::make('start_time');
```
