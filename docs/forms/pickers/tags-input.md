---
title: TagsInput
description: Free-form tag entry with suggestions and split keys.
order: 3
---

# TagsInput

Enter several free-form tags.

```php
use Laravilt\Forms\Components\TagsInput;

TagsInput::make('skills')
    ->suggestions(['PHP', 'Laravel', 'Vue.js', 'React'])
    ->splitKeys(['Tab', 'Enter', ','])
    ->maxTags(10);
```

## API reference

| Method | Description |
|--------|-------------|
| `suggestions(array\|Closure)` | Autocomplete suggestions |
| `splitKeys(array)` | Keys that create a tag |
| `separator(string)` | Separator when stored as a string |
| `maxTags(?int)` | Maximum number of tags |
