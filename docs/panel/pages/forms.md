---
title: Page Forms
description: Create pages with forms for settings and data entry
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
concept: pages
---

# Page Forms

Create pages with forms for settings and data entry.

## Basic Form Page

```php
<?php

namespace App\Laravilt\Admin\Pages;

use Laravilt\Panel\Pages\Page;
use Laravilt\Forms\Components\TextInput;
use Laravilt\Forms\Components\Toggle;
use Laravilt\Actions\Action;
use Laravilt\Notifications\Notification;

class Settings extends Page
{
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'site_name' => config('app.name'),
            'maintenance_mode' => app()->isDownForMaintenance(),
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('site_name')
                ->required(),
            Toggle::make('maintenance_mode')
                ->label('Maintenance Mode'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();
        // Save settings...

        Notification::make()
            ->title('Settings saved')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Changes')
                ->submit('save'),
        ];
    }
}
```

## With Sections

```php
<?php

namespace App\Laravilt\Admin\Pages;

use Laravilt\Panel\Pages\Page;
use Laravilt\Schemas\Components\Section;
use Laravilt\Forms\Components\TextInput;
use Laravilt\Forms\Components\FileUpload;
use Laravilt\Forms\Components\Toggle;
use Laravilt\Actions\Action;
use Laravilt\Notifications\Notification;

class GeneralSettings extends Page
{
    protected static ?string $navigationIcon = 'Settings';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $title = 'General Settings';
    protected static ?string $slug = 'settings/general';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'site_name' => setting('site_name'),
            'logo' => setting('logo'),
            'maintenance_mode' => setting('maintenance_mode'),
        ]);
    }

    protected function getFormSchema(): array
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

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            setting([$key => $value]);
        }

        Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Settings')
                ->submit('save'),
        ];
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('manage_settings');
    }
}
```
