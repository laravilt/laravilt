---
title: Creating Entries
description: Write the PHP class for a custom infolist entry.
order: 1
---

# Creating Entries

## Basic entry

Extend `Laravilt\Infolists\Entries\Entry` and add your options to `toLaraviltProps()`:

```php
<?php

namespace App\Infolists\Entries;

use Closure;
use Laravilt\Infolists\Entries\Entry;

class ProgressEntry extends Entry
{
    protected int|Closure $maxValue = 100;

    public function maxValue(int|Closure $max): static
    {
        $this->maxValue = $max;

        return $this;
    }

    public function toLaraviltProps(): array
    {
        return array_merge(parent::toLaraviltProps(), [
            'maxValue' => $this->evaluate($this->maxValue),
        ]);
    }
}
```

The serialized `component` key is the snake_case class name (`progress_entry`).

`Entry` already provides `color()`, `icon()`, `iconColor()`, `copyable()` and `formatStateUsing()`. Use them instead of redefining them.

## Usage

```php
use App\Infolists\Entries\ProgressEntry;

ProgressEntry::make('completion')
    ->maxValue(100)
    ->color('success');
```

## Extending an existing entry

To preconfigure a built-in entry, extend it. It keeps the parent's frontend component:

```php
<?php

namespace App\Infolists\Entries;

use Laravilt\Infolists\Entries\TextEntry;

class PriceEntry extends TextEntry
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->money('USD')->weight('bold');
    }
}
```
