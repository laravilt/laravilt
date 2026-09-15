---
title: Namespace Mappings
description: How Filament classes are converted to their Laravilt equivalents.
order: 2
---

# Namespace Mappings

`laravilt:filament` rewrites imports using these mappings.

## Resources & Pages

| Filament | Laravilt |
|----------|----------|
| `Filament\Resources\Resource` | `Laravilt\Panel\Resources\Resource` |
| `Filament\Resources\Pages\ListRecords` | `Laravilt\Panel\Pages\ListRecords` |
| `Filament\Resources\Pages\CreateRecord` | `Laravilt\Panel\Pages\CreateRecord` |
| `Filament\Resources\Pages\EditRecord` | `Laravilt\Panel\Pages\EditRecord` |
| `Filament\Resources\Pages\ViewRecord` | `Laravilt\Panel\Pages\ViewRecord` |
| `Filament\Resources\Pages\ManageRecords` | `Laravilt\Panel\Pages\ManageRecords` |
| `Filament\Resources\Pages\ManageRelatedRecords` | `Laravilt\Panel\Pages\ManageRelatedRecords` |
| `Filament\Resources\RelationManagers\RelationManager` | `Laravilt\Panel\Resources\RelationManagers\RelationManager` |
| `Filament\Pages\Page` | `Laravilt\Panel\Pages\Page` |
| `Filament\Pages\Dashboard` | `Laravilt\Panel\Pages\Dashboard` |

## Forms & Schemas

| Filament | Laravilt |
|----------|----------|
| `Filament\Forms\Form`, `Filament\Schemas\Schema` | `Laravilt\Schemas\Schema` |
| `Filament\Forms\Components\*` | `Laravilt\Forms\Components\*` |
| `Filament\Forms\Components\Section` / `Card` | `Laravilt\Schemas\Components\Section` |
| `Filament\Forms\Components\Grid`, `Tabs`, `Wizard`, `Fieldset` | `Laravilt\Schemas\Components\*` |
| `Filament\Schemas\Components\*` | `Laravilt\Schemas\Components\*` |
| `Filament\Forms\Get` / `Filament\Schemas\Components\Utilities\Get` | `Laravilt\Support\Utilities\Get` |
| `Filament\Forms\Set` / `Filament\Schemas\Components\Utilities\Set` | `Laravilt\Support\Utilities\Set` |

## Tables

| Filament | Laravilt |
|----------|----------|
| `Filament\Tables\Table` | `Laravilt\Tables\Table` |
| `Filament\Tables\Columns\*` | `Laravilt\Tables\Columns\*` |
| `Filament\Tables\Filters\*` | `Laravilt\Tables\Filters\*` |

## Infolists

| Filament | Laravilt |
|----------|----------|
| `Filament\Infolists\Infolist` | `Laravilt\Infolists\Infolist` |
| `Filament\Infolists\Components\*Entry` | `Laravilt\Infolists\Entries\*Entry` |

## Actions, Notifications & Widgets

| Filament | Laravilt |
|----------|----------|
| `Filament\Actions\*` | `Laravilt\Actions\*` |
| `Filament\Notifications\Notification` | `Laravilt\Notifications\Notification` |
| `Filament\Widgets\StatsOverviewWidget` | `Laravilt\Widgets\StatsOverviewWidget` |
| `Filament\Widgets\StatsOverviewWidget\Stat` | `Laravilt\Widgets\Stat` |
| `Filament\Widgets\ChartWidget` | `Laravilt\Widgets\ChartWidget` |

## Icons

Laravilt uses [Lucide](https://lucide.dev/icons) icons instead of Heroicons:

```php
// Filament (Heroicon)
protected static ?string $navigationIcon = 'heroicon-o-users';

// Laravilt (Lucide)
protected static ?string $navigationIcon = 'Users';
```

## Next Steps

- [Post-Migration Checklist](post-migration.md)
