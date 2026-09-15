---
title: Getting Started
description: What Laravilt is, and the shortest path from a fresh Laravel app to a working admin panel.
order: 1
---

# Getting Started

Laravilt is a modular admin panel framework for Laravel. You describe panels, resources, forms, tables and widgets in PHP, and Laravilt renders them as a single-page app through Inertia, using **Vue 3** (shadcn-vue) or **React 19** (shadcn/ui) with Tailwind CSS v4.

If you know Filament, most concepts carry over: a panel groups resources, a resource wires a model to a form, a table and pages, and components are configured with fluent `make()` builders.

## Try it first

- **Live demo:** [demo.laravilt.com](https://demo.laravilt.com). Log in with `admin@laravilt.com` / `password`.
- **Source:** every package lives in the [laravilt GitHub organization](https://github.com/laravilt).
- **Ask an AI assistant:** the hosted MCP server at `https://mcp.laravilt.com/mcp` gives Claude, Cursor and other MCP clients these docs and the package sources. See [MCP](../mcp/README.md).

## Read in this order

1. [Requirements](requirements.md): PHP, Laravel, Node and database versions.
2. [Installation](installation.md): create the app, pick Vue or React, run the installer.
3. [Installer Prompts](interactive-install.md): every question `laravilt:install` asks, and what it writes.
4. [Quick Start](quick-start.md): a working CRUD resource in five minutes.
5. [Your First Resource](first-resource.md): the generated files, explained and customized.
6. [Configuration](configuration.md): the panel provider, config files and environment keys.
7. [Frontend Stacks](frontend-stacks.md): how the Vue and React stacks differ.
8. [Troubleshooting](troubleshooting.md): fixes for common setup problems.
9. [Upgrading from 1.0](upgrade.md): moving to v1.1 (Laravel 13, React).
10. [Architecture](architecture.md): how the packages fit together.

After that, continue with [Panel & Resources](../panel/README.md).
