---
title: Commands
description: Generate and register Artisan commands in a plugin.
order: 3
---

# Commands

```bash
php artisan laravilt:make blog-manager command SyncPosts
```

The command is created in `src/Commands/`. Every generated plugin also includes an install command.

## Install command example

```php
namespace Laravilt\BlogManager\Commands;

use Illuminate\Console\Command;

class InstallBlogManagerCommand extends Command
{
    protected $signature = 'blog-manager:install {--force : Overwrite existing files}';

    protected $description = 'Install the Blog Manager plugin';

    public function handle(): int
    {
        $this->call('vendor:publish', [
            '--tag' => 'blog-manager-config',
            '--force' => $this->option('force'),
        ]);

        $this->call('migrate');

        $this->info('Blog Manager installed!');

        return self::SUCCESS;
    }
}
```

## Registering commands

Register commands in the plugin's service provider:

```php
public function boot(): void
{
    if ($this->app->runningInConsole()) {
        $this->commands([
            Commands\InstallBlogManagerCommand::class,
            Commands\SyncPosts::class,
        ]);
    }
}
```

The `HasCommands` trait offers the same thing through `pluginCommands([...])` and `registerPluginCommands()`. See [Traits](../concepts/traits.md).
