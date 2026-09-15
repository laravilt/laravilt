---
title: Confirmation
description: Ask for confirmation before an action runs, with modals, slide-overs, or a password prompt.
order: 2
---

# Confirmation

```php
use Laravilt\Actions\Action;

Action::make('archive')
    ->requiresConfirmation()
    ->modalHeading('Archive record')
    ->modalDescription('Are you sure you want to archive this record?')
    ->modalSubmitActionLabel('Yes, archive')
    ->modalCancelActionLabel('Cancel')
    ->action(fn ($record) => $record->archive());
```

## Icon and width

```php
Action::make('delete')
    ->requiresConfirmation()
    ->modalIcon('AlertTriangle')
    ->modalIconColor('destructive')
    ->modalWidth('lg')
    ->action(fn ($record) => $record->delete());
```

## Slide-over

Opens the modal as a side sheet:

```php
Action::make('settings')
    ->slideOver()
    ->modalHeading('Settings')
    ->schema([...]);
```

## Password confirmation

```php
Action::make('deleteAccount')
    ->requiresPassword()
    ->modalHeading('Delete account')
    ->modalDescription('Enter your password to confirm.')
    ->action(fn ($record) => $record->delete());
```

## Custom content

```php
Action::make('terms')
    ->modal()
    ->modalHeading('Terms of service')
    ->content('By continuing you agree to the terms.')
    ->isViewOnly();
```

## API reference

| Method | Description |
|--------|-------------|
| `requiresConfirmation()` | Show a confirmation modal |
| `modal()` | Open a modal without confirmation styling |
| `modalHeading()`, `modalDescription()` | Modal text |
| `modalSubmitActionLabel()`, `modalCancelActionLabel()` | Button labels |
| `modalIcon()`, `modalIconColor()` | Modal icon |
| `modalWidth()` | Modal width |
| `slideOver()` | Use a slide-over sheet |
| `requiresPassword()` | Require the user's password |
| `content()` | Static modal content |
| `isViewOnly()` | Hide the submit button |
