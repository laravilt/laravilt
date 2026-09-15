---
title: Schema Class
description: The Schema container, its configuration methods, validation helpers and serialization.
order: 1
---

# Schema Class

`Laravilt\Schemas\Schema` is the container behind resource forms and infolists. `Laravilt\Infolists\Infolist` extends it.

## Basic usage

```php
use Laravilt\Forms\Components\TextInput;
use Laravilt\Schemas\Schema;

$schema = Schema::make()
    ->schema([
        TextInput::make('name'),
        TextInput::make('email'),
    ])
    ->columns(2);
```

## Configuration

```php
Schema::make()
    ->schema([/* ... */])      // components
    ->columns(2)               // grid columns (int)
    ->model(User::class)       // model class
    ->resourceSlug('users')    // resource slug
    ->operation('edit')        // create, edit or view
    ->record($user)            // current record
    ->fill(['name' => 'Ada']); // initial data (array)
```

## Getters

| Method | Description |
|--------|-------------|
| `getSchema()` | Components |
| `getGridColumns()` | Column count |
| `getModel()` | Model class |
| `getOperation()` | Current operation |
| `getRecord()` | Current record |
| `getData()` | Filled data |
| `getVisibleComponents()` | Components that are not hidden |

## Validation

```php
$rules = $schema->getValidationRules();
$messages = $schema->getValidationMessages();
$attributes = $schema->getValidationAttributes();
```

## Serialization

```php
$props = $schema->toInertiaProps();   // for an Inertia page
$props = $schema->toLaraviltProps();  // component tree
```

## Related

- [Layout Components](components/README.md)
