---
title: Installation FAQ
description: Installation and setup questions
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: faq
---

# Installation FAQ

Common questions about installing and setting up Laravilt.

## How do I install Laravilt?

```bash
composer require laravilt/laravilt

php artisan laravilt:install
```

## Requirements

| Requirement | Version |
|-------------|---------|
| PHP | 8.2+ |
| Laravel | 12.x |
| Node.js | 18+ |
| Database | MySQL 8.0+, PostgreSQL 13+, SQLite 3.35+ |

## Does Laravilt support Laravel 12?

Yes, Laravilt fully supports Laravel 12.x with all features.

## How do I update Laravilt?

```bash
composer update laravilt/laravilt

php artisan laravilt:upgrade
```

## How do I create an admin panel?

```php
<?php

use Laravilt\Panel\Panel;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->login()
            ->resources([...]);
    }
}
```

## How do I add authentication?

```php
<?php

use Laravilt\Panel\Panel;

Panel::make()
    ->login()
    ->registration()
    ->passwordReset()
    ->emailVerification();
```

## How do I customize the theme?

```php
<?php

use Laravilt\Panel\Panel;

Panel::make()
    ->colors([
        'primary' => '#FF2D20',
    ])
    ->darkMode()
    ->favicon('/favicon.ico');
```

## How do I publish assets?

```bash
php artisan vendor:publish --tag=laravilt-assets

npm install && npm run build
```

## Related

- [Panel Documentation](../panel/introduction)
- [Auth Documentation](../auth/introduction)

