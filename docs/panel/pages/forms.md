---
title: Page Forms
description: Build settings and data-entry pages with a form schema and a save action.
order: 1
---

# Page Forms

A custom page renders form fields from `getSchema()`. When an action runs, it receives the submitted form data.

## Basic Form Page

```php
<?php

namespace App\Laravilt\Admin\Pages;

use Laravilt\Actions\Action;
use Laravilt\Forms\Components\TextInput;
use Laravilt\Forms\Components\Toggle;
use Laravilt\Notifications\Notification;
use Laravilt\Panel\Pages\Page;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'Settings';

    protected static ?string $title = 'Settings';

    protected function getSchema(): array
    {
        return [
            TextInput::make('site_name')
                ->default(config('app.name'))
                ->required(),
            Toggle::make('maintenance_mode')
                ->label('Maintenance Mode')
                ->default(app()->isDownForMaintenance()),
        ];
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Changes')
                ->action(function (array $data) {
                    // Persist $data ...

                    Notification::make()
                        ->title('Settings saved')
                        ->success()
                        ->send();
                }),
        ];
    }
}
```

## With Sections and a Settings Layout

```php
<?php

namespace App\Laravilt\Admin\Pages;

use Laravilt\Actions\Action;
use Laravilt\Forms\Components\FileUpload;
use Laravilt\Forms\Components\TextInput;
use Laravilt\Forms\Components\Toggle;
use Laravilt\Panel\Enums\PageLayout;
use Laravilt\Panel\Pages\Page;
use Laravilt\Schemas\Components\Section;

class GeneralSettings extends Page
{
    protected static ?string $navigationIcon = 'Settings';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $title = 'General Settings';

    protected static ?string $slug = 'settings/general';

    public function getLayout(): string
    {
        return PageLayout::Settings->value;
    }

    protected function getSchema(): array
    {
        return [
            Section::make('Site Information')
                ->columns(2)
                ->schema([
                    TextInput::make('site_name')
                        ->required()
                        ->maxLength(255),
                    FileUpload::make('logo')
                        ->image()
                        ->directory('branding'),
                ]),
            Section::make('Maintenance')
                ->schema([
                    Toggle::make('maintenance_mode')
                        ->label('Enable Maintenance Mode'),
                ]),
        ];
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Settings')
                ->action(fn (array $data) => $this->save($data)),
        ];
    }

    protected function save(array $data): void
    {
        // Persist settings ...
    }

    protected function authorizeAccess(): void
    {
        abort_unless(auth()->user()?->can('manage_settings'), 403);
    }
}
```

## Related

- [Forms](../../forms/README.md): all field types
- [Actions](../../actions/README.md): action options
- [Notifications](../../notifications/README.md)
