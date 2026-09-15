---
title: Forms MCP
description: Local MCP server that generates form classes.
order: 2
---

# Forms MCP Server

`Laravilt\Forms\Mcp\LaraviltFormsServer` generates form classes and searches the forms docs.

## Register

```php
// routes/ai.php
use Laravel\Mcp\Facades\Mcp;
use Laravilt\Forms\Mcp\LaraviltFormsServer;

Mcp::local('laravilt-forms', LaraviltFormsServer::class);
```

```bash
php artisan mcp:start laravilt-forms
```

## Tools

### generate-form-tool

Generates a new form class (the same result as `php artisan make:form`).

| Argument | Type | Required | Description |
|----------|------|----------|-------------|
| `name` | string | Yes | Form class name (StudlyCase) |
| `resource` | boolean | No | Generate a resource form |
| `force` | boolean | No | Overwrite an existing file |

### search-docs-tool

| Argument | Type | Required | Description |
|----------|------|----------|-------------|
| `query` | string | Yes | Search query |

## Example prompts

```
"Create a ContactForm."
"Create a resource form for posts."
"How do I validate file uploads?"
```

## Related

- [Forms](../forms/README.md)
