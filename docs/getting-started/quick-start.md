---
title: Quick Start
description: Generate a full CRUD resource from a database table in five minutes.
order: 4
---

# Quick Start

This guide assumes you finished [Installation](installation.md) and can log in to `/admin`.

## 1. Create a table

`laravilt:resource` builds a resource from an existing database table, so start with a migration:

```bash
php artisan make:migration create_products_table
```

```php
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->text('description')->nullable();
    $table->decimal('price', 10, 2);
    $table->integer('stock')->default(0);
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

```bash
php artisan migrate
```

## 2. Generate the resource

```bash
php artisan laravilt:resource admin --table=products
```

The generator reads the table's columns and asks a few questions: simple (single page with modal CRUD) or full pages, API endpoints, AI assistant configuration, and table features. It creates the `Product` model if it doesn't exist (pass `--model=` to choose the name), then writes:

```
app/Laravilt/Admin/Resources/Product/
├── ProductResource.php
├── Form/ProductForm.php
├── Table/ProductTable.php
├── InfoList/ProductInfoList.php
└── Pages/
    ├── ListProduct.php
    ├── CreateProduct.php
    ├── EditProduct.php
    └── ViewProduct.php
```

Resources are discovered automatically (`->discoverAutomatically()` in the panel provider), so nothing else needs registering.

## 3. Open it

Visit `/admin/products`. You get a searchable, sortable list with filters, and create, edit and view pages, plus delete and bulk delete, all built from the columns.

## 4. Tweak it

Fields live in `Form/ProductForm.php`:

```php
public static function configure(Schema $form): Schema
{
    return $form->schema([
        Section::make('Product')->columns(2)->schema([
            TextInput::make('name')->required()->maxLength(255),
            TextInput::make('price')->numeric()->prefix('$')->required(),
            Toggle::make('is_active')->default(true),
        ]),
    ]);
}
```

Columns live in `Table/ProductTable.php`:

```php
TextColumn::make('name')->searchable()->sortable(),
TextColumn::make('price')->money('USD')->sortable(),
ToggleColumn::make('is_active'),
```

Changes to PHP are picked up on the next request. You only need `npm run build` (or `npm run dev`) when you change frontend files.

## Next

- [Your First Resource](first-resource.md): every generated file, explained.
- [Forms](../forms/README.md) and [Tables](../tables/README.md): all components.
