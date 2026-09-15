---
title: Laravilt Documentation
description: Build Laravel admin panels with PHP, rendered in Vue or React through Inertia.
---

# Laravilt Documentation

Laravilt is a modular admin panel framework for Laravel. You define panels, resources, forms, tables and dashboards in PHP, and Laravilt renders them as a fast Inertia single-page app in **Vue 3** or **React 19**, styled with shadcn and Tailwind CSS v4.

**[Live demo](https://demo.laravilt.com)** (log in with `admin@laravilt.com` / `password`) · **[GitHub](https://github.com/laravilt)** · **MCP server:** `https://mcp.laravilt.com/mcp`

## Quick start

On a fresh Laravel app created with the Vue or React starter kit:

```bash
composer require laravilt/laravilt
php artisan laravilt:install
php artisan laravilt:resource admin --table=products
```

Then open `/admin`. The installer asks for your stack (or pass `--stack=vue|react`), sets up the panel, runs migrations and builds the assets. See [Installation](getting-started/installation.md).

> Laravel 13 and React require Laravilt v1.1 or later. 1.0.x supports Laravel 11/12 with Vue.

## Sections

| Section | What's inside |
|---------|---------------|
| [Getting Started](getting-started/README.md) | Requirements, installation, quick start, first resource, configuration, stacks, troubleshooting, upgrading |
| [Panel & Resources](panel/README.md) | Panels, resources, pages, navigation, tenancy, Filament migration |
| [Forms](forms/README.md) | Inputs, selects, pickers, uploads, repeaters, validation, reactivity |
| [Tables](tables/README.md) | Columns, filters, actions, search, sorting, grouping, display modes |
| [Actions](actions/README.md) | Create, edit, delete, export, import and custom actions |
| [Schemas](schemas/README.md) | Layout: sections, grids, tabs, wizards |
| [Infolists](infolists/README.md) | Read-only entries for view pages |
| [Notifications](notifications/README.md) | Toast and database notifications |
| [Widgets](widgets/README.md) | Stats and chart widgets for dashboards |
| [Auth](auth/README.md) | Login, 2FA, passkeys, social login, profile |
| [AI](ai/README.md) | Providers, chat, tools, agents, AI search |
| [Query Builder](query-builder/README.md) | Filtering and sorting Eloquent queries |
| [Plugins](plugins/README.md) | Build and share Laravilt plugins |
| [Frontend (Vue & React)](frontend/README.md) | Layouts, components, styling |
| [MCP](mcp/README.md) | Use Laravilt from Claude and other AI assistants |
| [Support](support/README.md) | Base component, concerns, utilities |
| [FAQ](faq/README.md) | Common questions |

## Help

- [GitHub Issues](https://github.com/laravilt/laravilt/issues)
- [Discord](https://discord.gg/gyRhbVUXEZ)

Laravilt is open-source software licensed under the MIT license.
