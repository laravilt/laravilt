# Laravilt Documentation

Laravilt is a modern, modular admin panel framework for Laravel 12+ with Vue 3 (Inertia.js v2) frontend. It provides a complete solution for building admin panels, dashboards, and CRUD applications with minimal code.

## Highlights

- **14 Modular Packages** - Use only what you need
- **Multi-Tenancy Support** - Single-database or multi-database SaaS architecture
- **30+ Form Fields** - Rich form components with validation
- **Powerful Tables** - Sortable, filterable, with bulk actions
- **8 Auth Methods** - OTP, 2FA, social login, passkeys, and more
- **AI Integration** - OpenAI, Anthropic, Gemini, DeepSeek providers
- **Vue 3 + Inertia.js** - Modern reactive frontend

## Table of Contents

### Getting Started
- [Installation](getting-started/installation.md)
- [Quick Start](getting-started/quick-start.md)
- [Architecture Overview](getting-started/architecture.md)

### Core Packages

#### Panel
- [Introduction](panel/introduction.md)
- [Creating Panels](panel/creating-panels.md)
- [Resources](panel/resources.md)
- [Pages](panel/pages.md)
- [Navigation](panel/navigation.md)
- [Themes & Branding](panel/themes.md)
- [Multi-Tenancy](panel/tenancy.md) - Single & Multi-Database SaaS support

#### Forms
- [Introduction](forms/introduction.md)
- [Field Types](forms/field-types.md)
- [Validation](forms/validation.md)
- [Layouts](forms/layouts.md)
- [Reactive Fields](forms/reactive-fields.md)
- [Custom Fields](forms/custom-fields.md)

#### Tables
- [Introduction](tables/introduction.md)
- [Columns](tables/columns.md)
- [Filters](tables/filters.md)
- [Actions](tables/actions.md)
- [API Reference](tables/api.md)

#### Actions
- [Introduction](actions/introduction.md)

#### Auth
- [Introduction](auth/introduction.md)
- [Authentication Methods](auth/methods.md)
- [Two-Factor Authentication](auth/two-factor.md)
- [Social Authentication](auth/social.md)
- [Passkeys](auth/passkeys.md)
- [Profile Management](auth/profile.md)

### Additional Packages
- [Schemas](schemas/introduction.md) - Layout components (Section, Tabs, Grid, Wizard)
- [Infolists](infolists/introduction.md) - Data display components
- [Widgets](widgets/introduction.md) - Stats, charts, and dashboard widgets
- [Notifications](notifications/introduction.md) - Toast notifications with actions
- [Query Builder](query-builder/introduction.md) - Advanced filtering and sorting
- [AI Integration](ai/introduction.md) - Multi-provider AI support
- [Plugins](plugins/introduction.md) - Plugin system
- [Support](support/introduction.md) - Foundation traits and utilities

### Frontend
- [Overview](frontend/README.md)
- [Components](frontend/components.md)
- [Layouts](frontend/layouts.md)
- [Styling](frontend/styling.md)
- [Utilities](frontend/utilities.md)

## Requirements

- PHP 8.2+
- Laravel 12.x
- Node.js 18+
- npm or pnpm

## Quick Installation

```bash
# Create a new Laravel project with Vue starter kit
laravel new my-project
cd my-project

# Install Laravilt
composer require laravilt/laravilt

# Run the installer
php artisan laravilt:install

# Build frontend assets
npm install && npm run build
```

## License

Laravilt is open-sourced software licensed under the [MIT license](LICENSE.md).

## Contributing

Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

## Support

- [GitHub Issues](https://github.com/laravilt/laravilt/issues)
- [Discussions](https://github.com/laravilt/laravilt/discussions)
