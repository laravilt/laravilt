<?php

declare(strict_types=1);

namespace Laravilt;

use Illuminate\Support\ServiceProvider;
use Laravilt\Commands\InstallCommand;
use Laravilt\Commands\MakePanelCommand;
use Laravilt\Commands\MakeResourceCommand;

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
            ]);
        }
    }
}
