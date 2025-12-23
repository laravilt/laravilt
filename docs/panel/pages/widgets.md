---
title: Page Widgets
description: Add widgets and header actions to pages
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
concept: pages
---

# Page Widgets

Add widgets and header actions to your pages.

## Page with Widgets

```php
<?php

namespace App\Laravilt\Admin\Pages;

use Laravilt\Panel\Pages\Page;
use App\Laravilt\Admin\Widgets\StatsOverviewWidget;
use App\Laravilt\Admin\Widgets\RevenueChartWidget;
use App\Laravilt\Admin\Widgets\LatestOrdersWidget;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'LayoutDashboard';
    protected static ?string $title = 'Dashboard';

    protected function getWidgets(): array
    {
        return [
            StatsOverviewWidget::class,
            RevenueChartWidget::class,
            LatestOrdersWidget::class,
        ];
    }

    protected function getWidgetsColumns(): int
    {
        return 2;
    }
}
```

## Header Actions

```php
<?php

namespace App\Laravilt\Admin\Pages;

use Laravilt\Panel\Pages\Page;
use Laravilt\Actions\Action;

class Reports extends Page
{
    protected function getHeaderActions(): array
    {
        return [
            Action::make('export')
                ->label('Export Data')
                ->icon('Download')
                ->action(fn () => $this->export()),
            Action::make('refresh')
                ->label('Refresh')
                ->icon('RefreshCw')
                ->action(fn () => $this->refresh()),
        ];
    }
}
```

## Subheading

```php
<?php

namespace App\Laravilt\Admin\Pages;

use Laravilt\Panel\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $title = 'Dashboard';

    protected function getSubheading(): ?string
    {
        return 'Welcome back, ' . auth()->user()->name;
    }
}
```

## Breadcrumbs

```php
<?php

namespace App\Laravilt\Admin\Pages;

use Laravilt\Panel\Pages\Page;

class GeneralSettings extends Page
{
    public function getBreadcrumbs(): array
    {
        return [
            route('laravilt.admin.dashboard') => 'Dashboard',
            route('laravilt.admin.settings') => 'Settings',
            'General' => null,
        ];
    }
}
```

## API Reference

| Property | Type | Description |
|----------|------|-------------|
| `$navigationIcon` | `string` | Lucide icon |
| `$navigationGroup` | `string` | Navigation group |
| `$navigationSort` | `int` | Sort order |
| `$navigationLabel` | `string` | Custom label |
| `$title` | `string` | Page title |
| `$slug` | `string` | URL slug |
| `$shouldRegisterNavigation` | `bool` | Show in nav |
