---
title: REST API
description: Expose a resource as a REST API and show it in the table's API view.
order: 6
---

# REST API

A resource can expose its records as a REST API. Override `api()` on the resource to enable it:

```php
use Laravilt\Panel\Resources\Resource;
use Laravilt\Tables\ApiColumn;
use Laravilt\Tables\ApiResource;

class UserResource extends Resource
{
    public static function api(ApiResource $api): ApiResource
    {
        return $api
            ->columns([
                ApiColumn::make('id')->type('integer')->readable()->sortable(),
                ApiColumn::make('name')->type('string')->searchable()->sortable(),
                ApiColumn::make('email')->type('string')->searchable(),
                ApiColumn::make('created_at')->type('datetime')->readable(),
            ])
            ->perPage(25)
            ->useAPITester();
    }
}
```

The panel registers routes under `/{panel}/api/{resource}`:

| Operation | Method | Toggle |
|-----------|--------|--------|
| List | `GET /{panel}/api/{resource}` | `list()` |
| Show | `GET /{panel}/api/{resource}/{id}` | `show()` |
| Create | `POST /{panel}/api/{resource}` | `create()` |
| Update | `PUT /{panel}/api/{resource}/{id}` | `update()` |
| Delete | `DELETE /{panel}/api/{resource}/{id}` | `delete()` |
| Bulk delete | `POST` (takes `ids`) | `bulkDelete()` |

Every operation uses `auth:sanctum` unless you change it. The list endpoint accepts `search`, `sort`, `direction`, and the filters you allow.

## Operations and middleware

```php
$api
    ->list()                                   // enabled, default middleware
    ->show(middleware: [])                     // public
    ->create(middleware: ['auth:sanctum', 'can:create-users'])
    ->delete(false)                            // disabled
    ->defaultMiddleware(['auth:sanctum']);
```

## Query options and validation

```php
$api
    ->allowedFilters(['status', 'role'])
    ->allowedSorts(['name', 'created_at'])
    ->allowedIncludes(['team'])
    ->fillable(['name', 'email'])
    ->createRules(['email' => ['required', 'email', 'unique:users']])
    ->updateRules(['email' => ['email']]);
```

`validationRequest()`, `createValidationRequest()`, and `updateValidationRequest()` accept a FormRequest class instead.

## Columns

| Method | Description |
|--------|-------------|
| `type()`, `format()`, `nullable()`, `enum()` | Schema type information |
| `readable()`, `writable()`, `creatable()`, `updatable()`, `writeOnly()` | Read/write access |
| `sortable()`, `filterable()`, `searchable()` | Query capabilities |
| `relationship()`, `nestedColumns()` | Related data |
| `transformUsing()`, `castAs()`, `default()` | Value handling |
| `description()`, `example()` | Documentation |

## Table API view

On the table itself, `api()` turns on the API view and tester for that table:

```php
$table->api();              // endpoint defaults to /api/{resource-slug}
$table->api('/api/users');  // custom endpoint
```

## OpenAPI

`ApiResource` can describe itself: `toOpenApi()`, `toOpenApiJson()`, and `toOpenApiYaml()`.

Custom endpoints can be added with `->actions([ApiAction::make('approve')->post()->action(fn ($record) => ...)])`.
