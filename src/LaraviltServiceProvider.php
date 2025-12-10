<?php

namespace Laravilt\Laravilt;

use Illuminate\Support\ServiceProvider;
use Laravel\Mcp\Facades\Mcp;
use Laravilt\Laravilt\Mcp\LaraviltServer;

class LaraviltServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Merge config
        $this->mergeConfigFrom(
            __DIR__ . '/../config/laravilt.php',
            'laravilt'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Load translations
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'laravilt');

        // Register MCP server
        if (class_exists(Mcp::class)) {
            Mcp::server('laravilt', LaraviltServer::class);
        }

        if ($this->app->runningInConsole()) {
            // Publish config
            $this->publishes([
                __DIR__ . '/../config/laravilt.php' => config_path('laravilt.php'),
            ], 'laravilt-config');

            // Register commands
            $this->commands([
                Commands\InstallLaraviltCommand::class,
                Commands\MakeUserCommand::class,
            ]);
        }
    }
}
