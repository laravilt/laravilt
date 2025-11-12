# Laravilt Framework

> **A complete full-stack framework for building admin panels, frontend applications, and mobile apps from a single PHP Resource definition.**

Laravilt generates Vue (web), Flutter (mobile), and REST APIs automatically, with built-in AI agent and MCP server support.

## Installation

### Requirements

- PHP 8.2+
- Laravel 12+
- Node.js 20+
- Composer

### Quick Start

```bash
# Install in existing Laravel 12 project
composer require laravilt/laravilt

# Run installation command
php artisan laravilt:install

# Create your first resource
php artisan laravilt:resource UserResource --model=User

# Install frontend dependencies and run dev server
npm install
npm run dev
```

Visit `http://your-app.test/admin` to see your Laravilt panel!

## What's Included

This meta-package includes all core Laravilt packages:

- **laravilt/support** - Foundation utilities and contracts
- **laravilt/core** - Component system base
- **laravilt/ui** - Base UI components (TextInput, Select, Toggle, DatePicker)
- **laravilt/forms** - Form builder with validation
- **laravilt/tables** - Table builder with filters and search
- **laravilt/grids** - Grid/card layouts with infinite scroll
- **laravilt/actions** - Action system (Edit, Delete, Bulk actions)
- **laravilt/infolists** - Detail view builder
- **laravilt/notifications** - Notification system
- **laravilt/widgets** - Dashboard widgets (Stats, Charts)
- **laravilt/query-builder** - Advanced filtering
- **laravilt/panel** - Main orchestrator

## Creating Resources

Resources are the core of Laravilt. Define once, generate for all platforms:

```php
<?php

namespace App\Laravilt\Resources;

use App\Models\User;
use Laravilt\Forms\Form;
use Laravilt\Tables\Table;
use Laravilt\Panel\Resources\Resource;
use Laravilt\UI\TextInput;
use Laravilt\Tables\Columns\TextColumn;

class UserResource extends Resource
{
    protected static string $model = User::class;

    protected static ?string $label = 'User';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->required(),
            TextInput::make('email')->email()->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->sortable()->searchable(),
            TextColumn::make('email')->sortable()->searchable(),
            TextColumn::make('created_at')->dateTime(),
        ]);
    }
}
```

This single definition automatically generates:
- ✅ Vue admin panel pages (list, create, edit, view)
- ✅ Flutter HMVC module (complete mobile app)
- ✅ REST API endpoints (CRUD + filters + pagination)

## Configuration

After installation, configure your panel in `config/laravilt.php`:

```php
return [
    'panel' => [
        'path' => '/admin',
        'domain' => null,
    ],

    'generate' => [
        'vue' => true,
        'flutter' => true,
        'api' => true,
    ],
];
```

## Documentation

For complete documentation, visit the main repository:
- [github.com/laravilt/laravilt](https://github.com/laravilt/laravilt)

## Support

- **Issues**: [github.com/laravilt/laravilt/issues](https://github.com/laravilt/laravilt/issues)
- **Discussions**: [github.com/laravilt/laravilt/discussions](https://github.com/laravilt/laravilt/discussions)

## License

Laravilt is open-sourced software licensed under the [MIT license](LICENSE.md).
