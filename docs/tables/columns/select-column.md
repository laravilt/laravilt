---
title: SelectColumn
description: Configure a select dropdown for a table column.
order: 6
---

# SelectColumn

```php
use Laravilt\Tables\Columns\SelectColumn;

SelectColumn::make('status')
    ->options([
        'draft' => 'Draft',
        'published' => 'Published',
        'archived' => 'Archived',
    ]);
```

> The bundled Vue and React tables have no dedicated renderer for `SelectColumn`. It displays with the text renderer, and the panel runs update hooks only for `ToggleColumn`. For inline editing today, use [ToggleColumn](toggle-column.md) or an [action with a form](../../actions/forms.md).

## Options

```php
use App\Models\Category;

SelectColumn::make('category_id')
    ->options(fn () => Category::pluck('name', 'id')->all())
    ->optionsSearchable()
    ->selectablePlaceholder(false)
    ->disableOptionWhen(fn ($value) => $value === 'archived');
```

## API reference

| Method | Description |
|--------|-------------|
| `options()` | Array or closure of options |
| `optionsSearchable()` | Searchable options |
| `native()` | Use a native `<select>` |
| `selectablePlaceholder()` | Allow selecting the empty placeholder |
| `disableOptionWhen()` | Disable individual options |
| `rules()` | Validation rules |
| `beforeStateUpdated()`, `afterStateUpdated()` | Update hooks |
