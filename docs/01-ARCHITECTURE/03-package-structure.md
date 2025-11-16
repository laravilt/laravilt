# Package Structure & Organization

## Overview

Laravilt uses a **monorepo** architecture with multiple packages, each publishable independently to Packagist (PHP) and pub.dev (Flutter).

## Monorepo Structure

```
laravilt/
├── packages/laravilt/          # All framework packages
│   ├── support/
│   ├── core/
│   ├── ui/
│   ├── forms/
│   ├── tables/
│   ├── grids/
│   ├── infolists/
│   ├── actions/
│   ├── notifications/
│   ├── widgets/
│   ├── query-builder/
│   ├── ai/
│   ├── mcp/
│   └── panel/
├── app/                        # Application code
├── resources/                  # Vue components
├── flutter_app/                # Flutter application
├── docs/                       # Documentation
├── tests/                      # Integration tests
└── composer.json               # Root composer with path repositories
```

## Package Organization

### Complete Package List

1. **laravilt/support** - Foundation utilities
2. **laravilt/core** - Component system base
3. **laravilt/ui** - Base UI components
4. **laravilt/forms** - Form builder
5. **laravilt/tables** - Table builder
6. **laravilt/grids** - Grid/card builder
7. **laravilt/infolists** - InfoList builder
8. **laravilt/actions** - Actions system
9. **laravilt/notifications** - Notifications
10. **laravilt/widgets** - Dashboard widgets
11. **laravilt/query-builder** - Advanced filtering
12. **laravilt/ai** - AI agent builder
13. **laravilt/mcp** - MCP server builder
14. **laravilt/panel** - Main orchestrator

### Package Dependencies

```
laravilt/support (no deps)
    ↓
laravilt/core (depends on: support)
    ↓
laravilt/ui (depends on: core, support)
    ↓
├─→ laravilt/forms (depends on: core, ui, support)
├─→ laravilt/tables (depends on: core, ui, support)
├─→ laravilt/grids (depends on: core, ui, support)
├─→ laravilt/infolists (depends on: core, ui, support)
├─→ laravilt/actions (depends on: core, ui, support)
├─→ laravilt/notifications (depends on: core, support)
└─→ laravilt/widgets (depends on: core, ui, support)
    ↓
laravilt/query-builder (depends on: core, support)
    ↓
laravilt/ai (depends on: core, support, forms, tables, grids)
laravilt/mcp (depends on: core, support, forms, tables, grids)
    ↓
laravilt/panel (depends on: ALL above packages)
```

## Standard Package Structure

Every package follows this structure:

```
packages/laravilt/{package-name}/
├── .github/
│   ├── workflows/
│   │   ├── laravel-tests.yml
│   │   ├── vue-tests.yml (if has Vue)
│   │   └── flutter-tests.yml (if has Flutter)
│   ├── FUNDING.yml (sponsor: fadymondy)
│   └── ISSUE_TEMPLATE/
│       ├── bug_report.md
│       └── feature_request.md
│
├── src/                        # PHP source code
│   ├── {Package}ServiceProvider.php
│   ├── Components/             # Component classes
│   ├── Concerns/               # Traits
│   ├── Contracts/              # Interfaces
│   ├── Commands/               # Artisan commands
│   └── [package-specific]
│
├── resources/
│   ├── js/                     # Vue components
│   │   ├── index.ts
│   │   ├── components/
│   │   ├── composables/
│   │   └── types/
│   └── flutter/                # Flutter widgets
│       ├── lib/
│       │   ├── {package}.dart
│       │   ├── widgets/
│       │   └── [package-specific]
│       └── pubspec.yaml
│
├── tests/
│   ├── php/                    # PHP/Pest tests
│   │   ├── Feature/
│   │   ├── Unit/
│   │   ├── Pest.php
│   │   └── TestCase.php
│   ├── vue/                    # Vue/Vitest tests
│   │   └── *.spec.ts
│   └── flutter/                # Flutter/Dart tests
│       └── *_test.dart
│
├── docs/
│   ├── installation.md
│   ├── basic-usage.md
│   ├── api-reference.md
│   └── examples/
│
├── .gitignore
├── CHANGELOG.md
├── CODE_OF_CONDUCT.md
├── LICENSE.md
├── README.md
├── SECURITY.md
├── composer.json               # PHP dependencies
├── package.json                # Vue dependencies (if has Vue)
├── pubspec.yaml                # Flutter dependencies (if has Flutter)
├── phpstan.neon
├── pint.json
└── testbench.yaml
```

## Root Composer Configuration

```json
{
    "name": "laravilt/laravilt",
    "type": "project",
    "repositories": [
        {"type": "path", "url": "packages/laravilt/support"},
        {"type": "path", "url": "packages/laravilt/core"},
        {"type": "path", "url": "packages/laravilt/ui"},
        {"type": "path", "url": "packages/laravilt/forms"},
        {"type": "path", "url": "packages/laravilt/tables"},
        {"type": "path", "url": "packages/laravilt/grids"},
        {"type": "path", "url": "packages/laravilt/infolists"},
        {"type": "path", "url": "packages/laravilt/actions"},
        {"type": "path", "url": "packages/laravilt/notifications"},
        {"type": "path", "url": "packages/laravilt/widgets"},
        {"type": "path", "url": "packages/laravilt/query-builder"},
        {"type": "path", "url": "packages/laravilt/ai"},
        {"type": "path", "url": "packages/laravilt/mcp"},
        {"type": "path", "url": "packages/laravilt/panel"}
    ],
    "require": {
        "laravilt/support": "*",
        "laravilt/core": "*",
        "laravilt/panel": "*"
    },
    "scripts": {
        "packages:install": "for package in packages/laravilt/*; do cd $package && composer install && cd -; done",
        "packages:test": "for package in packages/laravilt/*; do cd $package && composer test && cd -; done",
        "packages:lint": "for package in packages/laravilt/*; do cd $package && composer format && cd -; done",
        "packages:analyse": "for package in packages/laravilt/*; do cd $package && composer test:types && cd -; done",
        "packages:test-all": [
            "@packages:lint",
            "@packages:analyse",
            "@packages:test"
        ]
    }
}
```

## Package composer.json Template

```json
{
    "name": "laravilt/{package-name}",
    "description": "Package description",
    "keywords": ["laravel", "laravilt", "vue", "inertia", "flutter", "admin"],
    "homepage": "https://github.com/laravilt/{package-name}",
    "license": "MIT",
    "authors": [
        {
            "name": "Fady Mondy",
            "email": "fadymondy@example.com",
            "role": "Developer"
        }
    ],
    "require": {
        "php": "^8.2",
        "illuminate/contracts": "^11.0|^12.0",
        "inertiajs/inertia-laravel": "^2.0"
    },
    "require-dev": {
        "laravel/pint": "^1.24",
        "larastan/larastan": "^3.0",
        "nunomaduro/collision": "^8.0",
        "orchestra/testbench": "^9.0",
        "pestphp/pest": "^4.0",
        "pestphp/pest-plugin-laravel": "^4.0",
        "phpstan/phpstan": "^2.0"
    },
    "autoload": {
        "psr-4": {
            "Laravilt\\{Package}\\": "src/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Laravilt\\{Package}\\Tests\\": "tests/"
        }
    },
    "scripts": {
        "test": "vendor/bin/pest",
        "test:coverage": "vendor/bin/pest --coverage",
        "test:types": "vendor/bin/phpstan analyse --memory-limit=2G",
        "test:style": "vendor/bin/pint --test",
        "format": "vendor/bin/pint"
    },
    "config": {
        "sort-packages": true,
        "allow-plugins": {
            "pestphp/pest-plugin": true
        }
    },
    "extra": {
        "laravel": {
            "providers": [
                "Laravilt\\{Package}\\{Package}ServiceProvider"
            ]
        }
    },
    "minimum-stability": "dev",
    "prefer-stable": true
}
```

## Vue package.json Template

```json
{
    "name": "@laravilt/{package-name}",
    "version": "0.1.0",
    "description": "Package description",
    "main": "resources/js/index.ts",
    "types": "resources/js/index.d.ts",
    "exports": {
        ".": "./resources/js/index.ts",
        "./components": "./resources/js/components/index.ts",
        "./composables": "./resources/js/composables/index.ts",
        "./types": "./resources/js/types/index.ts"
    },
    "keywords": ["laravilt", "vue", "inertia", "components"],
    "author": "Fady Mondy",
    "license": "MIT",
    "peerDependencies": {
        "vue": "^3.5.0",
        "@inertiajs/vue3": "^2.0.0"
    },
    "devDependencies": {
        "@types/node": "^22.0.0",
        "@vitejs/plugin-vue": "^6.0.0",
        "typescript": "^5.2.0",
        "vitest": "^2.0.0",
        "vue-tsc": "^2.0.0"
    }
}
```

## Flutter pubspec.yaml Template

```yaml
name: laravilt_{package_name}
description: Package description
version: 0.1.0
homepage: https://github.com/laravilt/{package-name}

environment:
  sdk: '>=3.0.0 <4.0.0'

dependencies:
  flutter:
    sdk: flutter
  flutter_riverpod: ^2.5.0
  freezed_annotation: ^2.4.0
  json_annotation: ^4.9.0

dev_dependencies:
  flutter_test:
    sdk: flutter
  flutter_lints: ^3.0.0
  build_runner: ^2.4.0
  freezed: ^2.4.0
  json_serializable: ^6.7.0
  mockito: ^5.4.0

flutter:
  # Plugin metadata if needed
```

## Package Testing

Each package has its own test suite:

```bash
# In package directory
composer test                 # Run Pest tests
composer test:coverage        # With coverage
composer test:types           # PHPStan analysis
composer test:style           # Pint code style
composer format               # Auto-fix code style

# Vue tests (if applicable)
npm run test

# Flutter tests (if applicable)
cd resources/flutter && flutter test
```

## Publishing Packages

### To Packagist (PHP)

1. Tag version: `git tag v0.1.0`
2. Push tag: `git push --tags`
3. Submit to Packagist.org
4. Packagist auto-updates on new tags

### To pub.dev (Flutter)

1. Update version in `pubspec.yaml`
2. Run `flutter pub publish --dry-run`
3. Run `flutter pub publish`
4. Package is now on pub.dev

## Version Management

All packages use **synchronized versioning**:
- All packages share the same version number
- Releasing v0.2.0 means all packages are v0.2.0
- Simplifies dependency management

## Development Workflow

### 1. Clone Repository
```bash
git clone https://github.com/laravilt/laravilt.git
cd laravilt
```

### 2. Install Root Dependencies
```bash
composer install
npm install
```

### 3. Install Package Dependencies
```bash
composer packages:install
```

### 4. Make Changes
Work in specific package directory

### 5. Test Changes
```bash
cd packages/laravilt/{package}
composer test
```

### 6. Test All Packages
```bash
composer packages:test-all
```

### 7. Commit & Push
```bash
git add .
git commit -m "feat: add new feature"
git push
```

## Next Steps

- Read `04-IMPLEMENTATION-GUIDES/01-sprint-01-foundation.md` to start building
- Read `02-CORE-CONCEPTS/` to understand each package's purpose
