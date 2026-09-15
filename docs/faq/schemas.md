---
title: Schemas FAQ
description: Questions about grids, sections, tabs and wizards.
order: 4
---

# Schemas FAQ

Layout components live in `Laravilt\Schemas\Components` and work in forms and infolists.

## How do I create a multi-column layout?

```php
use Laravilt\Forms\Components\TextInput;
use Laravilt\Schemas\Components\Grid;

Grid::make(2)->schema([
    TextInput::make('first_name'),
    TextInput::make('last_name'),
]);
```

## How do I make columns responsive?

```php
Grid::make()
    ->columns(['default' => 1, 'md' => 2, 'lg' => 3])
    ->schema([...]);
```

## How do I create a section?

```php
use Laravilt\Schemas\Components\Section;

Section::make('user_information')
    ->heading('User Information')
    ->description('Basic user details')
    ->icon('User')
    ->collapsible()
    ->collapsed()
    ->schema([...]);
```

## How do I create tabs?

```php
use Laravilt\Schemas\Components\Tab;
use Laravilt\Schemas\Components\Tabs;

Tabs::make('settings')->tabs([
    Tab::make('general')->label('General')->icon('Settings')->schema([...]),
    Tab::make('advanced')->label('Advanced')->schema([...]),
]);
```

## How do I create a multi-step form?

```php
use Laravilt\Schemas\Components\Step;
use Laravilt\Schemas\Components\Wizard;

Wizard::make('onboarding')->steps([
    Step::make('account')->label('Account')->schema([...]),
    Step::make('profile')->label('Profile')->schema([...]),
]);
```

## Related

- [Schemas Documentation](../schemas/README.md)
- [Forms FAQ](forms.md)
