---
title: Hidden
description: Store a value in the form without displaying it.
order: 5
---

# Hidden

A hidden field that stores a value without displaying it.

```php
use Laravilt\Forms\Components\Hidden;

Hidden::make('user_id')
    ->default(auth()->id());

Hidden::make('organization_id')
    ->default(fn () => auth()->user()->organization_id);
```

Hidden fields support all the shared field methods, such as `default()`, `dehydrated()` and `rules()`.
