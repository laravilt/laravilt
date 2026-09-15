---
title: DateRangePicker
description: Pick a start and end date in one field.
order: 4
---

# DateRangePicker

Pick a start date and an end date in a single field.

```php
use Laravilt\Forms\Components\DateRangePicker;

DateRangePicker::make('period')
    ->label('Reporting Period')
    ->minDate('2026-01-01')
    ->maxDate('2026-12-31')
    ->numberOfMonths(2)
    ->closeOnSelect();
```

## API reference

| Method | Description |
|--------|-------------|
| `minDate(string)` / `maxDate(string)` | Bounds |
| `numberOfMonths(int)` | Months shown side by side |
| `closeOnSelect(bool)` | Close after the range is picked |
| `locale(string)` | Calendar locale |
