---
title: Resources
description: Generate panel resources inside a plugin.
order: 1
---

# Resources

```bash
php artisan laravilt:make blog-manager resource Post
```

This creates a full resource under `src/Resources/Posts/`:

```
src/Resources/Posts/
├── PostResource.php
├── Pages/
│   ├── ListPosts.php
│   ├── CreatePost.php
│   ├── EditPost.php
│   └── ViewPost.php
├── Schemas/
│   ├── PostForm.php
│   └── PostInfolist.php
└── Tables/
    └── PostsTable.php
```

## Generated resource

```php
namespace Laravilt\BlogManager\Resources\Posts;

use Laravilt\BlogManager\Resources\Posts\Pages\CreatePost;
use Laravilt\BlogManager\Resources\Posts\Pages\EditPost;
use Laravilt\BlogManager\Resources\Posts\Pages\ListPosts;
use Laravilt\BlogManager\Resources\Posts\Pages\ViewPost;
use Laravilt\BlogManager\Resources\Posts\Schemas\PostForm;
use Laravilt\BlogManager\Resources\Posts\Schemas\PostInfolist;
use Laravilt\BlogManager\Resources\Posts\Tables\PostsTable;
use Laravilt\Panel\Resources\Resource;
use Laravilt\Schemas\Schema;
use Laravilt\Tables\Table;

class PostResource extends Resource
{
    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'layers';

    public static function getModel(): string
    {
        return \App\Models\Post::class;
    }

    public static function form(Schema $schema): Schema
    {
        return PostForm::make($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PostInfolist::make($schema);
    }

    public static function table(Table $table): Table
    {
        return PostsTable::make($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'view' => ViewPost::route('/{record}'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }
}
```

> `getModel()` points to `App\Models\{Name}`. If the model lives in the plugin (`laravilt:make blog-manager model Post`), change it to the plugin's model class.

The form schema starts with a `Section` containing a `TextInput::make('name')`. Edit `Schemas/PostForm.php`, `Schemas/PostInfolist.php` and `Tables/PostsTable.php` to add your fields and columns.

## Register in the plugin

```php
public function register(Panel $panel): void
{
    $panel->resources([
        Resources\Posts\PostResource::class,
    ]);
}
```

## Related

- [Resources in the panel docs](../../panel/resources/README.md)
