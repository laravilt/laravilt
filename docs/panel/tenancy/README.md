---
title: Multi-Tenancy
description: Build SaaS panels with single-database or multi-database tenancy.
order: 10
---

# Multi-Tenancy

Laravilt panels can be tenant-aware. With single-database tenancy, records are scoped to a tenant such as a team in one shared database. With multi-database tenancy, each tenant gets its own database and subdomain.

1. [Overview](overview.md): the two modes and how to enable them
2. [Teams Tenancy](teams.md): use a `Team` model as the tenant
3. [Configuration](configuration.md): panel methods, config file and environment
4. [Tenant Models](models.md): the `Tenant` and `Domain` models
5. [Middleware & Routing](middleware.md): how tenants are identified
6. [Best Practices](best-practices.md): tips and troubleshooting
