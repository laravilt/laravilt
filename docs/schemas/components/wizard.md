---
title: Wizard
description: Multi-step flow with labelled steps and custom button labels.
order: 4
---

# Wizard

A multi-step flow.

```php
use Laravilt\Forms\Components\TextInput;
use Laravilt\Schemas\Components\Step;
use Laravilt\Schemas\Components\Wizard;

Wizard::make('onboarding')
    ->skippable()
    ->submitButtonLabel('Create Account')
    ->nextButtonLabel('Continue')
    ->previousButtonLabel('Back')
    ->steps([
        Step::make('account')
            ->label('Account')
            ->description('Login credentials')
            ->icon('User')
            ->schema([
                TextInput::make('email')->email()->required(),
                TextInput::make('password')->password()->required(),
            ]),
        Step::make('profile')
            ->label('Profile')
            ->icon('UserCircle')
            ->schema([
                TextInput::make('name')->required(),
            ]),
    ]);
```

The panel's schema renderer maps `wizard` on both stacks, so a Wizard works inside resource forms. Each step renders its schema like any other form content.

## API reference

**Wizard**

| Method | Description |
|--------|-------------|
| `make(string)` | Create (name required) |
| `steps(array)` | `Step` instances |
| `skippable(bool)` | Allow jumping between steps |
| `submitButtonLabel()` / `nextButtonLabel()` / `previousButtonLabel()` | Button labels |

**Step**

| Method | Description |
|--------|-------------|
| `make(string)` | Create |
| `label(string\|Closure)` | Step label |
| `description(string\|Closure)` | Step description |
| `icon(string\|Closure)` | Lucide icon |
| `schema(array)` | Step content |
