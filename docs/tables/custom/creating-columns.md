---
title: Creating Columns
description: Package reusable column configurations as your own column classes.
order: 1
---

# Creating Columns

The frontend has renderers for text, icon, image, color, toggle, select, text input, and checkbox columns. The simplest way to build your own column is to extend one of these classes and configure it in `setUp()`. `setUp()` runs every time `make()` is called.

```php
namespace App\Tables\Columns;

use Laravilt\Tables\Columns\TextColumn;

class StatusColumn extends TextColumn
{
    protected function setUp(): void
    {
        $this
            ->badge()
            ->sortable()
            ->color(fn (?string $state) => match ($state) {
                'active' => 'success',
                'pending' => 'warning',
                'banned' => 'destructive',
                default => 'secondary',
            })
            ->formatStateUsing(fn (?string $state) => str($state)->headline());
    }
}
```

```php
use App\Tables\Columns\StatusColumn;

$table->columns([
    StatusColumn::make('status'),
]);
```

## Adding options

Add fluent methods like any other column:

```php
namespace App\Tables\Columns;

use Laravilt\Tables\Columns\TextColumn;

class ProgressColumn extends TextColumn
{
    protected int $max = 100;

    public function max(int $max): static
    {
        $this->max = $max;

        return $this;
    }

    protected function setUp(): void
    {
        $this->suffix('%')->formatStateUsing(
            fn ($state) => round(((float) $state / $this->max) * 100)
        );
    }
}
```

> Each column serializes a `component` name that the table uses to choose a renderer. Unknown names fall back to the text renderer, and there is no public API yet for registering new cell renderers. Extend one of the built-in column classes as shown above.
