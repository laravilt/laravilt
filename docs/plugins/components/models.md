---
title: Models
description: Generate Eloquent models, migrations and factories inside a plugin.
order: 2
---

# Models

```bash
php artisan laravilt:make blog-manager model Post
php artisan laravilt:make blog-manager migration Post
php artisan laravilt:make blog-manager factory PostFactory
```

The model is created in `src/Models/` under the plugin namespace. Add fillable fields, casts and relations as you would in any Laravel app:

```php
namespace Laravilt\BlogManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'category_id', 'published_at'];

    protected function casts(): array
    {
        return ['published_at' => 'datetime'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
```

`migration Post` creates `database/migrations/{timestamp}_create_posts_table.php`. `factory PostFactory` creates `database/factories/PostFactory.php` in the `{Namespace}\Database\Factories` namespace, linked to `{Namespace}\Models\Post`.

Make sure the plugin's service provider loads its migrations (the generator adds this when you select the migrations feature):

```php
$this->loadMigrationsFrom(__DIR__.'/../database/migrations');
```
