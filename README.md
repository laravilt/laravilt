# Laravilt

A modern Laravel Admin Panel built with Vue 3, Inertia.js, and AI capabilities. Inspired by Filament but powered by the frontend.

[![Latest Stable Version](https://poser.pugx.org/laravilt/laravilt/version.svg)](https://packagist.org/packages/laravilt/laravilt)
[![License](https://poser.pugx.org/laravilt/laravilt/license.svg)](https://packagist.org/packages/laravilt/laravilt)
[![Downloads](https://poser.pugx.org/laravilt/laravilt/d/total.svg)](https://packagist.org/packages/laravilt/laravilt)

## Features

- **Modern Stack**: Laravel 12, Vue 3, Inertia.js v2, Tailwind CSS v4
- **Beautiful UI**: Built on shadcn/vue and Reka UI components
- **AI Integration**: Multi-provider AI support (OpenAI, Anthropic, Gemini)
- **Global Search**: AI-powered search across all resources
- **Rich Form Builder**: 30+ field types with validation
- **Powerful Tables**: Sorting, filtering, bulk actions, exports
- **Notifications**: Real-time in-app notifications
- **Widgets**: Dashboard widgets with charts and stats
- **Multi-tenancy**: Built-in tenant support
- **Authentication**: Multiple auth methods (passwords, social, passkeys)
- **RTL Support**: Full right-to-left language support
- **Dark Mode**: System-aware theming

## Included Packages

This meta-package includes all Laravilt components:

| Package | Description |
|---------|-------------|
| `laravilt/support` | Core utilities and helpers |
| `laravilt/panel` | Admin panel core framework |
| `laravilt/auth` | Authentication system |
| `laravilt/forms` | Form builder with 30+ fields |
| `laravilt/tables` | Table builder with actions |
| `laravilt/actions` | Action system for CRUD |
| `laravilt/schemas` | Schema definitions |
| `laravilt/infolists` | Information display lists |
| `laravilt/notifications` | Notification system |
| `laravilt/widgets` | Dashboard widgets |
| `laravilt/query-builder` | Query building utilities |
| `laravilt/ai` | AI assistant integration |
| `laravilt/plugins` | Plugin system & generators |

## Requirements

- PHP 8.3+
- Laravel 12+
- Node.js 18+
- npm or pnpm

## Installation

```bash
composer require laravilt/laravilt
```

Run the installer:

```bash
php artisan laravilt:install
```

This will:
- Publish all configurations
- Run migrations
- Setup frontend assets
- Clear caches

### Create Admin User

```bash
php artisan laravilt:make-user
```

## Quick Start

### 1. Create a Panel

```bash
php artisan laravilt:panel admin
```

### 2. Create a Resource

```bash
php artisan laravilt:resource User --generate
```

This generates a complete CRUD resource with:
- Resource class
- Form definition
- Table definition
- List, Create, Edit, View pages

### 3. Configure the Panel

```php
// app/Providers/Laravilt/AdminPanelProvider.php
use Laravilt\Panel\Panel;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => '#3b82f6',
            ])
            ->discoverResources(in: app_path('Laravilt/Admin/Resources'))
            ->discoverPages(in: app_path('Laravilt/Admin/Pages'))
            ->globalSearch()
            ->aiProviders(fn ($ai) => $ai
                ->openai()
                ->anthropic()
            );
    }
}
```

## CLI Commands

### Panel Management
- `laravilt:panel {name}` - Create a new panel
- `laravilt:page {name}` - Create a panel page
- `laravilt:cluster {name}` - Create a page cluster

### Resource Management
- `laravilt:resource {name}` - Create a resource
- `laravilt:relation {name}` - Create a relation manager

### Plugin Development
- `laravilt:plugin {name}` - Create a new plugin
- `laravilt:component {name}` - Generate plugin components
- `laravilt:make {type}` - Generate Laravel components in plugin

### System
- `laravilt:install` - Install/update Laravilt
- `laravilt:make-user` - Create admin user

## Configuration

Publish the configuration:

```bash
php artisan vendor:publish --tag=laravilt-config
```

Key configuration options in `config/laravilt.php`:

```php
return [
    'user_model' => App\Models\User::class,
    'path' => 'admin',
    'guard' => 'web',
    'locale' => 'en',
    'locales' => ['en' => 'English', 'ar' => 'Arabic'],
    'dark_mode' => true,
    'features' => [
        'ai_assistant' => true,
        'global_search' => true,
        'notifications' => true,
    ],
    'ai' => [
        'provider' => env('LARAVILT_AI_PROVIDER', 'openai'),
        'model' => env('LARAVILT_AI_MODEL', 'gpt-4'),
    ],
];
```

## Form Fields

Available form field types:

- Text, Textarea, RichEditor, MarkdownEditor
- Number, Currency, Percent
- Select, MultiSelect, Radio, Checkbox
- Toggle, Switch
- DatePicker, DateTimePicker, TimePicker, DateRangePicker
- FileUpload, ImageUpload
- ColorPicker, IconPicker
- Repeater, Builder, KeyValue
- Code Editor, JSON Editor
- Tags, Rating, Slider
- And more...

## Table Features

- Sortable columns
- Searchable columns
- Filterable with custom filters
- Bulk actions
- Row actions
- Export to CSV/Excel
- Pagination with per-page options
- Sticky header support
- Column visibility toggle

## AI Features

### Global Search
AI-enhanced search across all registered resources.

### AI Chat
Built-in chat interface supporting:
- OpenAI (GPT-3.5, GPT-4, GPT-4o)
- Anthropic (Claude 3, Claude 3.5)
- Google Gemini

Configure providers in `.env`:

```env
OPENAI_API_KEY=sk-...
ANTHROPIC_API_KEY=sk-ant-...
GOOGLE_AI_API_KEY=...
```

## Testing

```bash
composer test
```

## Code Style

```bash
composer format
```

## License

The MIT License (MIT). See [License File](LICENSE.md) for more information.

## Credits

- Built by [Fady Mondy](https://github.com/3x1io)
- Inspired by [Filament PHP](https://filamentphp.com)
- UI components from [shadcn/vue](https://www.shadcn-vue.com)
