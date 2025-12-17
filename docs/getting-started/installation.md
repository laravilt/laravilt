# Installation

This guide will walk you through installing Laravilt in a new Laravel project.

## Prerequisites

Before installing Laravilt, ensure you have:

- **PHP 8.2+** with extensions: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
- **Composer 2.x**
- **Node.js 18+** and npm/pnpm
- **Database**: MySQL 8.0+, PostgreSQL 13+, or SQLite 3.35+

## Step 1: Create a New Laravel Project

Laravilt requires a fresh Laravel 12 installation with the Vue.js starter kit.

```bash
# Using Laravel Installer
laravel new my-admin-panel
```

```bash
┌ Which starter kit would you like to install? ────────────────┐
│   ○ None                                                     │
│   ○ React                                                    │
│ › ● Vue                                                      │
│   ○ Livewire                                                 │
└──────────────────────────────────────────────────────────────┘
```

then

```bash
┌ Which authentication provider do you prefer? ────────────────┐
│ › ● Laravel's built-in authentication                        │
│   ○ WorkOS (Requires WorkOS account)                         │
│   ○ No authentication scaffolding                            │
└──────────────────────────────────────────────────────────────┘
```

then

```bash
┌ Which testing framework do you prefer? ──────────────────────┐
│ › ● Pest                                                     │
│   ○ PHPUnit                                                  │
└──────────────────────────────────────────────────────────────┘
```

Navigate to your project:

```bash
cd my-admin-panel
```

## Step 2: Run the Installer

The Laravilt installer will set up everything you need:

```bash
php artisan laravilt:install
```

The installer will:
1. Publish configuration files
2. Publish frontend assets and components
3. Set up the database migrations
4. Create the default admin panel
5. Configure authentication
6. Set up the service providers

### Interactive Installation Options

During installation, you'll be prompted for:

```
┌ What features do you want to enable? ───────────────────────────┐
│ ◼ Two-Factor Authentication                                     │
│ ◼ Social Authentication                                         │
│ ◼ Passkeys (WebAuthn)                                          │
│ ◼ API Tokens                                                    │
│ ◼ AI Integration                                                │
└─────────────────────────────────────────────────────────────────┘
```

## Step 3: Configure Environment

Update your `.env` file:

```env
APP_NAME="My Admin Panel"
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=my_admin_panel
DB_USERNAME=root
DB_PASSWORD=

# Session driver (database recommended for session management)
SESSION_DRIVER=database

# Queue connection (for notifications, emails)
QUEUE_CONNECTION=database
```

## Step 4: Run Migrations

```bash
php artisan migrate
```

## Step 5: Create Admin User

```bash
php artisan laravilt:user
```

Follow the prompts to create your first admin user:

```
┌ What is the admin's name? ──────────────────────────────────────┐
│ Admin User                                                      │
└─────────────────────────────────────────────────────────────────┘

┌ What is the admin's email? ─────────────────────────────────────┐
│ admin@example.com                                               │
└─────────────────────────────────────────────────────────────────┘

┌ What is the admin's password? ──────────────────────────────────┐
│ ••••••••                                                        │
└─────────────────────────────────────────────────────────────────┘
```

## Step 6: Build Frontend Assets

```bash
npm install
npm run build
```

For development with hot reloading:

```bash
npm run dev
```

## Step 7: Start the Application

Using Laravel's built-in server:

```bash
php artisan serve
```

Or with Laravel Herd/Valet:

```bash
# Access at https://my-admin-panel.test
```

For full-stack development with all services:

```bash
composer run dev
```

This starts:
- Laravel development server
- Vite dev server with HMR
- Queue worker
- Log viewer

## Step 8: Access Your Panel

Open your browser and navigate to:

```
http://localhost:8000/admin
```

Log in with the credentials you created in Step 7.

---

## Installation Options

### Minimal Installation

For a minimal setup without optional features:

```bash
php artisan laravilt:install --minimal
```

### With Specific Features

Enable specific features during installation:

```bash
php artisan laravilt:install --two-factor --social-auth --passkeys
```

### Custom Panel Path

Configure a custom panel path:

```bash
php artisan laravilt:install --path=dashboard
```

---

## Post-Installation

### Directory Structure

After installation, your project will have:

```
app/
├── Laravilt/
│   └── Admin/                    # Default admin panel
│       ├── AdminPanelProvider.php
│       ├── Pages/
│       │   └── Dashboard.php
│       └── Resources/
│           └── UserResource.php
├── Models/
│   └── User.php
└── Providers/
    └── LaraviltServiceProvider.php

resources/
├── js/
│   ├── pages/
│   │   └── admin/               # Panel pages
│   └── components/              # Vue components
└── css/
    └── app.css

config/
├── laravilt.php                 # Main config
├── laravilt-panel.php           # Panel config
├── laravilt-auth.php            # Auth config
└── laravilt-*.php               # Other packages
```

### Service Provider Registration

The installer automatically registers the service providers in `bootstrap/providers.php`:

```php
return [
    App\Providers\AppServiceProvider::class,
    App\Providers\LaraviltServiceProvider::class,
    App\Laravilt\Admin\AdminPanelProvider::class,
];
```

---

## Troubleshooting

### Common Issues

**Assets not loading:**
```bash
npm run build
php artisan optimize:clear
```

**Database connection errors:**
```bash
php artisan config:clear
php artisan migrate:fresh
```

**Permission errors:**
```bash
chmod -R 775 storage bootstrap/cache
```

**Vite manifest not found:**
```bash
rm -rf node_modules
npm install
npm run build
```

### Getting Help

If you encounter issues:

1. Check the [GitHub Issues](https://github.com/laravilt/laravilt/issues)
2. Search [Discussions](https://github.com/laravilt/laravilt/discussions)
3. Review the Laravel and Inertia.js documentation

---

## Next Steps

- [Configuration Guide](configuration.md) - Customize your installation
- [Quick Start Guide](quick-start.md) - Build your first resource
- [Architecture Overview](architecture.md) - Understand how Laravilt works
