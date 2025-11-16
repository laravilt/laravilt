<?php

declare(strict_types=1);

namespace Laravilt;

use Illuminate\Support\ServiceProvider;
use Laravilt\Commands\InstallCommand;
use Laravilt\Commands\MakePanelCommand;
use Laravilt\Commands\MakeResourceCommand;
use Laravilt\Commands\RestoreCommand;
use Laravilt\Commands\UpdateCommand;

class LaraviltServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravilt.php', 'laravilt');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/laravilt.php' => config_path('laravilt.php'),
            ], 'laravilt-config');

            $this->commands([
                InstallCommand::class,
                MakeResourceCommand::class,
                MakePanelCommand::class,
                UpdateCommand::class,
                RestoreCommand::class,
            ]);
        }
    }
}
