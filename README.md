![laravilt](https://raw.githubusercontent.com/laravilt/laravilt/master/arts/hero.jpg)

# Laravilt

A modern admin panel framework for Laravel 13, rendered through Inertia.js with **Vue 3 or React 19**, with built-in AI capabilities. Inspired by Filament but powered by the frontend.

> **v1.1 is out:** React 19 support alongside Vue 3, and Laravel 13 compatibility. See [Frontend Stacks](docs/getting-started/frontend-stacks.md) and [Upgrading](docs/getting-started/upgrade.md).

[![Latest Stable Version](https://poser.pugx.org/laravilt/laravilt/version.svg)](https://packagist.org/packages/laravilt/laravilt)
[![License](https://poser.pugx.org/laravilt/laravilt/license.svg)](https://packagist.org/packages/laravilt/laravilt)
[![Downloads](https://poser.pugx.org/laravilt/laravilt/d/total.svg)](https://packagist.org/packages/laravilt/laravilt)
[![PHP](https://img.shields.io/badge/PHP-8.3%20%7C%208.4-777BB4?logo=php&logoColor=white)](docs/getting-started/requirements.md)
[![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![Vue](https://img.shields.io/badge/Vue-3-4FC08D?logo=vuedotjs&logoColor=white)](docs/getting-started/frontend-stacks.md)
[![React](https://img.shields.io/badge/React-19-61DAFB?logo=react&logoColor=black)](docs/getting-started/frontend-stacks.md)
[![Dependabot Updates](https://github.com/laravilt/laravilt/actions/workflows/dependabot/dependabot-updates/badge.svg)](https://github.com/laravilt/laravilt/actions/workflows/dependabot/dependabot-updates)
[![PHP Code Styling](https://github.com/laravilt/laravilt/actions/workflows/fix-php-code-styling.yml/badge.svg)](https://github.com/laravilt/laravilt/actions/workflows/fix-php-code-styling.yml)
[![Tests](https://github.com/laravilt/laravilt/actions/workflows/tests.yml/badge.svg)](https://github.com/laravilt/laravilt/actions/workflows/tests.yml)

## Features

- **Modern Stack**: Laravel 13, Inertia.js, TypeScript, Tailwind CSS v4
- **Vue 3 or React 19**: Pick your frontend per app; the same PHP panels, resources, forms and tables render in either stack
- **Beautiful UI**: Built on shadcn-vue (Reka UI) for Vue and shadcn/ui (Radix) for React
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

## Screenshots

### Dashboard & Widgets
<table>
<tr>
<td width="50%"><img src="arts/14-dashboard-widgets.png" alt="Dashboard Widgets"></td>
<td width="50%"><img src="arts/16-dashboard-light-mode.png" alt="Dashboard Light Mode"></td>
</tr>
</table>

### Products Management

**Table View & CRUD Operations**
<table>
<tr>
<td width="50%"><img src="arts/01-products-table-view.png" alt="Products Table"></td>
<td width="50%"><img src="arts/02-products-create-form.png" alt="Create Product"></td>
</tr>
<tr>
<td width="50%"><img src="arts/03-products-edit-form.png" alt="Edit Product"></td>
<td width="50%"><img src="arts/04-products-view-infolist.png" alt="View Product"></td>
</tr>
</table>

**Grid Views**
<table>
<tr>
<td width="50%"><img src="arts/06-products-grid-view.png" alt="Products Grid"></td>
<td width="50%"><img src="arts/48-products-grid-badges.png" alt="Grid with Badges"></td>
</tr>
<tr>
<td width="50%"><img src="arts/45-products-grid-filters.png" alt="Grid with Filters"></td>
<td width="50%"><img src="arts/46-products-grid-toggle.png" alt="Grid Toggle View"></td>
</tr>
<tr>
<td width="50%"><img src="arts/47-products-grid-sorting.png" alt="Grid Sorting"></td>
<td width="50%"><img src="arts/44-simple-resource.png" alt="Simple Resource"></td>
</tr>
</table>

### Grid Simple Card
<table>
<tr>
<td width="50%"><img src="arts/07-customers-grid-view.png" alt="Customers Grid"></td>
<td width="50%"></td>
</tr>
</table>

### API & Endpoints
<table>
<tr>
<td width="50%"><img src="arts/08-api-products-list-endpoint.png" alt="API Products List"></td>
<td width="50%"><img src="arts/09-api-products-list-response.png" alt="API Response"></td>
</tr>
<tr>
<td width="50%"><img src="arts/10-api-products-get-one.png" alt="API Get One"></td>
<td width="50%"><img src="arts/11-api-customers-create.png" alt="API Customers Create"></td>
</tr>
<tr>
<td width="50%"><img src="arts/12-api-create.png" alt="API Create"></td>
<td width="50%"></td>
</tr>
</table>

### AI Chat
<table>
<tr>
<td width="50%"><img src="arts/20-ai-chat-empty.png" alt="AI Chat Interface"></td>
<td width="50%"><img src="arts/21-ai-chat-mention-menu.png" alt="AI Resource Mention"></td>
</tr>
<tr>
<td width="50%"><img src="arts/22-ai-chat-conversation.png" alt="AI Conversation"></td>
<td width="50%"><img src="arts/29-global-search-ai.png" alt="Global Search with AI"></td>
</tr>
</table>

### Authentication

**Login & Registration**
<table>
<tr>
<td width="50%"><img src="arts/39-auth-login.png" alt="Login"></td>
<td width="50%"><img src="arts/40-auth-register.png" alt="Register"></td>
</tr>
<tr>
<td width="50%"><img src="arts/41-auth-forgot-password.png" alt="Forgot Password"></td>
<td width="50%"></td>
</tr>
</table>

**Two-Factor Authentication**
<table>
<tr>
<td width="50%"><img src="arts/25-settings-2fa-active.png" alt="2FA Active"></td>
<td width="50%"><img src="arts/27-settings-2fa.png" alt="2FA Settings"></td>
</tr>
<tr>
<td width="50%"><img src="arts/28-settings-2fa-qr.png" alt="2FA QR Code"></td>
<td width="50%"><img src="arts/49-settings-2fa-setup.png" alt="2FA Setup"></td>
</tr>
<tr>
<td width="50%"><img src="arts/50-settings-2fa-qr-code.png" alt="2FA QR Code Scan"></td>
<td width="50%"><img src="arts/51-settings-2fa-recovery-codes.png" alt="2FA Recovery Codes"></td>
</tr>
<tr>
<td width="50%"><img src="arts/52-settings-2fa-verify.png" alt="2FA Verify"></td>
<td width="50%"><img src="arts/53-auth-2fa-challenge.png" alt="2FA Challenge"></td>
</tr>
<tr>
<td width="50%"><img src="arts/54-auth-2fa-authenticator.png" alt="2FA Authenticator"></td>
<td width="50%"><img src="arts/55-auth-2fa-recovery.png" alt="2FA Recovery"></td>
</tr>
<tr>
<td width="50%"><img src="arts/56-auth-2fa-success.png" alt="2FA Success"></td>
<td width="50%"><img src="arts/26-settings-2fa-disable-modal.png" alt="2FA Disable Modal"></td>
</tr>
</table>

### Settings

**Profile & Security**
<table>
<tr>
<td width="50%"><img src="arts/23-settings-profile.png" alt="Profile Settings"></td>
<td width="50%"><img src="arts/24-settings-password.png" alt="Password Settings"></td>
</tr>
<tr>
<td width="50%"><img src="arts/19-settings-browser-sessions.png" alt="Browser Sessions"></td>
<td width="50%"><img src="arts/37-settings-connected-accounts.png" alt="Connected Accounts"></td>
</tr>
</table>

**Passkeys**
<table>
<tr>
<td width="50%"><img src="arts/34-settings-passkeys.png" alt="Passkeys"></td>
<td width="50%"><img src="arts/35-settings-passkeys-register.png" alt="Register Passkey"></td>
</tr>
<tr>
<td width="50%"><img src="arts/36-settings-passkey-save.png" alt="Save Passkey"></td>
<td width="50%"></td>
</tr>
</table>

**API Tokens**
<table>
<tr>
<td width="50%"><img src="arts/30-settings-api-tokens-list.png" alt="API Tokens List"></td>
<td width="50%"><img src="arts/42-settings-create-token.png" alt="Create Token"></td>
</tr>
<tr>
<td width="50%"><img src="arts/43-settings-api-tokens.png" alt="API Tokens"></td>
<td width="50%"><img src="arts/33-theme-api-token-empty.png" alt="API Token Empty State"></td>
</tr>
<tr>
<td width="50%"><img src="arts/31-settings-revoke-confirm.png" alt="Revoke Confirm"></td>
<td width="50%"><img src="arts/32-settings-revoke-tokens.png" alt="Revoke Tokens"></td>
</tr>
</table>

**Preferences & Localization**
<table>
<tr>
<td width="50%"><img src="arts/38-settings-locale-timezone.png" alt="Language & Timezone"></td>
<td width="50%"></td>
</tr>
</table>

### Global Features

**Search & Navigation**
<table>
<tr>
<td width="50%"><img src="arts/17-global-search.png" alt="Global Search"></td>
<td width="50%"><img src="arts/18-global-search-results.png" alt="Search Results"></td>
</tr>
<tr>
<td width="50%"><img src="arts/15-user-menu.png" alt="User Menu"></td>
<td width="50%"></td>
</tr>
</table>

**Notifications**
<table>
<tr>
<td width="50%"><img src="arts/13-notifications-panel-empty.png" alt="Notifications"></td>
<td width="50%"></td>
</tr>
</table>

### Modals & Dialogs
<table>
<tr>
<td width="50%"><img src="arts/05-modal-delete-confirm.png" alt="Delete Confirmation"></td>
<td width="50%"></td>
</tr>
</table>

## Documentation

Full documentation lives in [`docs/`](docs/README.md):

| Section | What's inside |
|---------|---------------|
| [Getting Started](docs/getting-started/README.md) | [Requirements](docs/getting-started/requirements.md), [installation](docs/getting-started/installation.md), [quick start](docs/getting-started/quick-start.md), [first resource](docs/getting-started/first-resource.md), [frontend stacks](docs/getting-started/frontend-stacks.md), [upgrading](docs/getting-started/upgrade.md) |
| [Panel & Resources](docs/panel/README.md) | Panels, resources, pages, navigation, tenancy, Filament migration |
| [Forms](docs/forms/README.md) | Inputs, selects, pickers, uploads, repeaters, validation, reactivity |
| [Tables](docs/tables/README.md) | Columns, filters, actions, search, sorting, grouping, display modes |
| [Actions](docs/actions/README.md) | Create, edit, delete, export, import and custom actions |
| [Schemas](docs/schemas/README.md) | Layout: sections, grids, tabs, wizards |
| [Infolists](docs/infolists/README.md) | Read-only entries for view pages |
| [Notifications](docs/notifications/README.md) | Toast and database notifications |
| [Widgets](docs/widgets/README.md) | Stats and chart widgets for dashboards |
| [Auth](docs/auth/README.md) | Login, 2FA, passkeys, social login, profile |
| [AI](docs/ai/README.md) | Providers, chat, tools, agents, AI search |
| [Query Builder](docs/query-builder/README.md) | Filtering and sorting Eloquent queries |
| [Plugins](docs/plugins/README.md) | Build and share Laravilt plugins |
| [Frontend (Vue & React)](docs/frontend/README.md) | Layouts, components, styling |
| [MCP](docs/mcp/README.md) | Use Laravilt from Claude and other AI assistants |
| [Support](docs/support/README.md) | Base component, concerns, utilities |
| [FAQ](docs/faq/README.md) | Common questions |

## Included Packages

This meta-package includes all Laravilt components:

| Package | Description | Documentation |
|---------|-------------|---------------|
| `laravilt/support` | Core utilities and helpers | [Docs](docs/support/README.md) |
| `laravilt/panel` | Admin panel core framework | [Docs](docs/panel/README.md) |
| `laravilt/auth` | Authentication system | [Docs](docs/auth/README.md) |
| `laravilt/forms` | Form builder with 30+ fields | [Docs](docs/forms/README.md) |
| `laravilt/tables` | Table builder with actions | [Docs](docs/tables/README.md) |
| `laravilt/actions` | Action system for CRUD | [Docs](docs/actions/README.md) |
| `laravilt/schemas` | Schema definitions | [Docs](docs/schemas/README.md) |
| `laravilt/infolists` | Information display lists | [Docs](docs/infolists/README.md) |
| `laravilt/notifications` | Notification system | [Docs](docs/notifications/README.md) |
| `laravilt/widgets` | Dashboard widgets | [Docs](docs/widgets/README.md) |
| `laravilt/query-builder` | Query building utilities | [Docs](docs/query-builder/README.md) |
| `laravilt/ai` | AI assistant integration | [Docs](docs/ai/README.md) |
| `laravilt/plugins` | Plugin system & generators | [Docs](docs/plugins/README.md) |

## Requirements

- PHP 8.3 or 8.4
- Laravel 13 (Laravilt 1.0.x supports Laravel 11/12 with Vue only)
- Node.js 20+ with npm
- A Laravel Inertia starter kit: **Vue** (Vue 3) or **React** (React 19)

See [Requirements](docs/getting-started/requirements.md) for databases and extensions.

## Installation

Laravilt installs on a fresh Laravel app created with the Vue or React starter kit. The installer detects the stack from your `package.json`, or you can pass it with `--stack`.

### Vue 3

```bash
laravel new my-app   # choose the Vue starter kit
cd my-app
composer require laravilt/laravilt
php artisan laravilt:install --stack=vue
```

### React 19

```bash
laravel new my-app   # choose the React starter kit
cd my-app
composer require laravilt/laravilt
php artisan laravilt:install --stack=react
```

The installer:
- Publishes the configs and the frontend for your stack, and writes `LARAVILT_FRONTEND=vue|react` to `.env`
- Runs migrations
- Creates the admin panel provider
- Runs `npm install` and `npm run build`

Use `--skip-npm` to build the assets yourself. The installer overwrites starter-kit files, so run it on a fresh app or commit first. See [Installation](docs/getting-started/installation.md) for every option.

### Create Admin User

```bash
php artisan laravilt:user
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
- `laravilt:install` - Install/update Laravilt (`--stack=vue|react`)
- `laravilt:user` - Create admin user

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

## Contributing

Contributions are welcome. Read the [contributing guide](.github/CONTRIBUTING.md) before opening a pull request, and report security issues as described in the [security policy](.github/SECURITY.md).

## License

The MIT License (MIT). See [License File](LICENSE.md) for more information.

## Credits

- Built by [Fady Mondy](https://github.com/3x1io)
- Inspired by [Filament PHP](https://filamentphp.com)
- UI components from [shadcn-vue](https://www.shadcn-vue.com) and [shadcn/ui](https://ui.shadcn.com)
