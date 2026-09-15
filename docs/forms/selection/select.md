---
title: Select
description: Dropdown with search, multiple selection, relationships and dependent options.
order: 1
---

# Select

A dropdown with search, multiple selection and relationship support.

## Basic usage

```php
use Laravilt\Forms\Components\Select;

Select::make('status')
    ->options([
        'draft' => 'Draft',
        'published' => 'Published',
    ]);
```

## Searchable

```php
Select::make('country')
    ->searchable()
    ->options(Country::pluck('name', 'id')->all());
```

## Multiple selection

```php
Select::make('tags')
    ->multiple()
    ->minItems(1)
    ->maxItems(5);
```

## Relationships

```php
Select::make('category_id')
    ->relationship('category', 'name')
    ->searchable()
    ->preload();

// Modify the relationship query
Select::make('author_id')
    ->relationship('author', 'name', fn ($query) => $query->where('active', true));
```

## Create and edit options inline

```php
use Laravilt\Forms\Components\TextInput;

Select::make('category_id')
    ->relationship('category', 'name')
    ->createOptionForm([
        TextInput::make('name')->required(),
    ])
    ->editOptionForm([
        TextInput::make('name')->required(),
    ]);
```

## Dependent selects

```php
Select::make('country_id')
    ->options(Country::pluck('name', 'id')->all())
    ->live();

Select::make('state_id')
    ->options(fn ($get) => State::where('country_id', $get('country_id'))->pluck('name', 'id')->all())
    ->dependsOn('country_id');
```

## Boolean select

```php
Select::make('is_featured')->boolean('Yes', 'No');
```

## API reference

| Method | Description |
|--------|-------------|
| `options(array\|Closure)` | Set options |
| `searchable(bool\|array)` | Enable search, optionally on specific columns |
| `multiple(bool)` | Allow multiple values |
| `minItems(?int)` / `maxItems(?int)` | Selection limits for multiple mode |
| `relationship(name, titleAttribute, ?modifyQuery)` | Load options from a relationship |
| `preload(bool)` | Load all relationship options up front |
| `native(bool)` | Use the native `<select>` element |
| `dependsOn(string\|array)` | Reload options when other fields change |
| `optionsLimit(int)` | Limit options shown |
| `getSearchResultsUsing(Closure)` | Custom search |
| `getOptionLabelUsing(Closure)` | Custom label for the selected value |
| `createOptionForm(array)` / `createOptionUsing(Closure)` | Inline creation |
| `editOptionForm(array)` / `updateOptionUsing(Closure)` | Inline editing |
| `disableOptionWhen(Closure)` | Disable individual options |
| `boolean(?true, ?false, ?placeholder)` | Yes/No options |
| `allowHtml(bool)` | Render option labels as HTML |
| `searchDebounce(int)` | Search debounce in milliseconds |

## Related

- [Radio](radio.md)
- [CheckboxList](checkbox-list.md)
- [Reactive Fields](../reactive/README.md)
