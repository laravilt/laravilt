---
title: CreateAction
description: Create records through the create page or a modal form.
order: 3
---

# CreateAction

```php
use Laravilt\Actions\CreateAction;

CreateAction::make();
```

Defaults: icon `Plus`, color `primary`. Hidden when the user can't create records.

Inside a resource, it configures itself from the page:

- **Full resources**: links to the resource's create page.
- **Simple ("manage records") resources**: opens a modal with the resource form, creates the record, and shows a success notification.

## Modal form outside a resource

```php
use App\Models\Post;
use Laravilt\Forms\Components\Select;
use Laravilt\Forms\Components\TextInput;

CreateAction::make()
    ->model(Post::class)
    ->formSchema([
        TextInput::make('title')->required(),
        Select::make('status')->options([
            'draft' => 'Draft',
            'published' => 'Published',
        ]),
    ])
    ->using(); // default handler: fill and save a new Post
```

`formSchema()` switches the action to a modal, sets the submit/cancel labels, and uses a `lg` width.

## Custom creation logic

```php
CreateAction::make()
    ->model(Post::class)
    ->formSchema([...])
    ->using(function ($record, array $data) {
        return auth()->user()->posts()->create($data);
    });
```

## API reference

| Method | Description |
|--------|-------------|
| `model(string)` | Model class to create |
| `formSchema(array)` | Modal form fields |
| `using(?Closure)` | Creation handler; no argument uses the default |
| `modalHeading()`, `modalWidth()`, `slideOver()` | Modal options |
