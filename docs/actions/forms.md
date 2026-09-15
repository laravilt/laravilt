---
title: Forms
description: Collect input or show record details in an action modal.
order: 3
---

# Forms

## Modal form

`schema()` (or its aliases `form()` and `modalFormSchema()`) adds [form fields](../forms/README.md) to the modal. The submitted values arrive in `$data`.

```php
use Laravilt\Actions\Action;
use Laravilt\Forms\Components\Select;
use Laravilt\Forms\Components\Textarea;

Action::make('changeStatus')
    ->modalHeading('Change status')
    ->schema([
        Select::make('status')
            ->options([
                'draft' => 'Draft',
                'published' => 'Published',
                'archived' => 'Archived',
            ])
            ->required(),

        Textarea::make('reason')->rows(3),
    ])
    ->action(function ($record, array $data) {
        $record->update($data);
    });
```

## Prefill the form

```php
use Laravilt\Forms\Components\TextInput;

Action::make('updatePrice')
    ->schema([
        TextInput::make('price')->numeric()->required(),
    ])
    ->fillForm(fn ($record) => ['price' => $record->price])
    ->action(fn ($record, array $data) => $record->update($data));
```

Use `defaultFormData([...])` for defaults that don't depend on a record.

## View-only modal

Show [infolist entries](../infolists/README.md) without a submit button:

```php
use Laravilt\Infolists\Entries\TextEntry;

Action::make('details')
    ->modalHeading('User details')
    ->modalInfolistSchema([
        TextEntry::make('name'),
        TextEntry::make('email'),
        TextEntry::make('created_at')->dateTime(),
    ])
    ->isViewOnly();
```

## API reference

| Method | Description |
|--------|-------------|
| `schema()` / `form()` / `modalFormSchema()` | Form fields in the modal |
| `fillForm(Closure)` | Initial values from the record |
| `defaultFormData(array)` | Initial values without a record |
| `modalInfolistSchema()` | Read-only entries |
| `isViewOnly()` | Hide the submit button |
