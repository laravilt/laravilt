---
title: SelectFilter
description: Filter records by one or more values from a list or relationship.
order: 1
---

# SelectFilter

```php
use Laravilt\Tables\Filters\SelectFilter;

SelectFilter::make('status')
    ->options([
        'draft' => 'Draft',
        'published' => 'Published',
    ]);
```

By default the filter runs `where(name, value)`, or `whereIn` when `multiple()` is enabled.

## Multiple selection

```php
use App\Models\Category;

SelectFilter::make('category_id')
    ->multiple()
    ->options(fn () => Category::pluck('name', 'id')->all());
```

## Relationship

Options load from the relationship, and the query uses `whereHas`:

```php
SelectFilter::make('category')
    ->relationship('category', 'name')
    ->searchable()
    ->preload();
```

## Custom query

The closure receives the query and the selected value:

```php
SelectFilter::make('state')
    ->options(['active' => 'Active', 'inactive' => 'Inactive'])
    ->query(fn ($query, $value) => $query->where('is_active', $value === 'active'));
```

## API reference

| Method | Description |
|--------|-------------|
| `options()` | Array or closure of options |
| `multiple()` | Allow several values |
| `searchable()` | Searchable dropdown |
| `relationship()` | Load options from a relationship |
| `preload()` | Preload relationship options |
| `hasEmptyOption()`, `emptyRelationshipOptionLabel()` | "None" option for relationships |
| `selectablePlaceholder()` | Allow clearing the selection |
| `query()` | Custom query |
| `default()` | Default value |
