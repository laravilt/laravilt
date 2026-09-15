---
title: Custom Fields
description: Create your own form field types with a PHP class and a Vue or React component.
order: 10
---

# Custom Fields

A custom field has two parts:

1. **A PHP class** that extends `Laravilt\Forms\Components\Field` and passes its options to the frontend in `toLaraviltProps()`.
2. **A frontend component** (Vue or React) registered as `laravilt-{kebab-name}`.

Generate both with:

```bash
php artisan make:form-component EmojiPicker --vue
php artisan make:form-component EmojiPicker --react
```

> React support requires Laravilt v1.1 or later.

This creates `app/Forms/Components/EmojiPicker.php` and `resources/js/components/forms/emoji-picker.vue` (or `.tsx`).

Before building a field, check the built-in ones. For example, [RateInput](../pickers/rate-input.md) already covers star ratings.

## Pages

1. [Creating Fields](creating-fields.md): write the PHP field class
2. [Frontend Components](frontend-components.md): build and register the Vue or React component
