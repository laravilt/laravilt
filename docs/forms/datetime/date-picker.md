---
title: DatePicker
description: Date selection with a calendar popup, formats and constraints.
order: 1
---

# DatePicker

Date selection with a calendar popup.

## Basic usage

```php
use Laravilt\Forms\Components\DatePicker;

DatePicker::make('birth_date')
    ->label('Date of Birth');
```

## Formats

```php
DatePicker::make('event_date')
    ->format('Y-m-d')          // stored value
    ->displayFormat('F j, Y')  // shown to the user
    ->locale('fr');
```

## Constraints

```php
DatePicker::make('start_date')
    ->minDate(now())
    ->maxDate(now()->addYear())
    ->disabledDates(['2026-12-25', '2027-01-01']);
```

## Time and calendar options

```php
DatePicker::make('starts_at')
    ->time()             // include time selection
    ->seconds()
    ->minutesStep(15)
    ->timezone('Europe/Paris')
    ->weekStartsOnMonday()
    ->closeOnDateSelection();

DatePicker::make('dob')->native(); // native browser input
```

## API reference

| Method | Description |
|--------|-------------|
| `format(string)` | Storage format |
| `displayFormat(string)` | Display format |
| `locale(string)` / `timezone(string)` | Locale and timezone |
| `minDate()` / `maxDate()` | Date bounds |
| `disabledDates(array\|Closure)` | Dates that can't be picked |
| `date()` / `time()` / `datetime()` / `seconds()` | Which parts to pick |
| `format12hr(bool)` | 12-hour clock |
| `hoursStep()` / `minutesStep()` / `secondsStep()` | Time steps |
| `firstDayOfWeek(int)` / `weekStartsOnMonday()` / `weekStartsOnSunday()` | Calendar start day |
| `closeOnDateSelection(bool)` | Close after picking |
| `defaultFocusedDate()` | Month shown when empty |
| `native(bool)` | Use the native input |
