---
title: Requirements
description: PHP, Laravel, Node.js and database versions Laravilt needs.
order: 1
---

# Requirements

| Requirement | Version |
|-------------|---------|
| PHP | 8.3 or 8.4 |
| Laravel | 13 (Laravilt v1.1+), or 11/12 on Laravilt 1.0.x |
| Composer | 2.x |
| Node.js | 20+ with npm |
| Database | MySQL 8+, PostgreSQL 13+ or SQLite 3.35+ |

> Laravel 13 and the React stack require Laravilt v1.1 or later. Laravilt 1.0.x supports Laravel 11 and 12 with the Vue stack only.

## PHP extensions

The usual Laravel set: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO (plus the driver for your database), Tokenizer and XML.

## Frontend

Laravilt installs on top of one of Laravel's official Inertia starter kits:

| Stack | Starter kit | UI library |
|-------|-------------|------------|
| Vue 3 | Vue | shadcn-vue (Reka UI) |
| React 19 | React | shadcn/ui (Radix) |

Both stacks use TypeScript, Vite and Tailwind CSS v4. See [Frontend Stacks](frontend-stacks.md).

## Production notes

- HTTPS is required for passkeys (WebAuthn).
- Run a queue worker if you use database notifications, exports/imports or AI features.
- Redis for cache and sessions is recommended, but not required.

## Next

Continue with [Installation](installation.md).
