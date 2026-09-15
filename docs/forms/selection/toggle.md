---
title: Toggle
description: On/off switch with custom values, labels, icons and colors.
order: 5
---

# Toggle

An on/off switch.

## Basic usage

```php
use Laravilt\Forms\Components\Toggle;

Toggle::make('is_active')
    ->label('Active');
```

## Colors, icons and labels

```php
Toggle::make('published')
    ->onColor('success')
    ->offColor('danger')
    ->onIcon('Bell')
    ->offIcon('BellOff')
    ->onLabel('Published')
    ->offLabel('Draft');
```

## Custom values

```php
Toggle::make('status')
    ->onValue('active')
    ->offValue('inactive');
```

## Reactive toggle

```php
Toggle::make('has_discount')
    ->live()
    ->afterStateUpdated(function ($state, $set) {
        if (! $state) {
            $set('discount_percentage', null);
        }
    });
```

## API reference

| Method | Description |
|--------|-------------|
| `onColor(string)` / `offColor(string)` | Colors per state |
| `onIcon(string)` / `offIcon(string)` | Lucide icons per state |
| `onLabel()` / `offLabel()` | Labels per state |
| `onValue(mixed)` / `offValue(mixed)` | Stored values |
| `inline(bool)` | Inline layout |
