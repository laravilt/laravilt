---
title: Migration Overview
description: Run laravilt:filament to convert Filament resources, pages and widgets.
order: 1
---

# Migration Overview

The migration tool converts Filament PHP v3/v4 code into Laravilt code.

## Prerequisites

- A working Filament v3 or v4 application
- Laravilt installed (`php artisan laravilt:install`)
- A backup or clean git state

## Quick Start

```bash
php artisan laravilt:filament
```

This will:

1. Scan your `app/Filament` directory
2. List the resources, pages and widgets it found
3. Let you pick which ones to migrate
4. Write Laravilt classes to `app/Laravilt/Admin`

## Command Options

| Option | Default | Description |
|--------|---------|-------------|
| `--source=` | `app/Filament` | Directory with Filament classes |
| `--target=` | `app/Laravilt` | Target directory |
| `--panel=` | `Admin` | Panel name |
| `--dry-run` | | Show what would change without writing files |
| `--force` | | Overwrite existing files |
| `--all` | | Migrate everything without prompting |

## Full Example

```bash
php artisan laravilt:filament \
    --source=app/Filament \
    --target=app/Laravilt \
    --panel=Admin \
    --force \
    --all
```

## Next Steps

- [Namespace Mappings](namespace-mappings.md)
- [Post-Migration Checklist](post-migration.md)
