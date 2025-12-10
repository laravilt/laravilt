<?php

namespace Laravilt\Laravilt;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Laravilt\Plugins\PluginProvider;

class LaraviltPlugin extends PluginProvider implements Plugin
{
    /**
     * The plugin ID (must be unique).
     */
    protected static string $id = 'laravilt';

    /**
     * The plugin name.
     */
    protected static string $name = 'Laravilt';

    /**
     * The plugin version.
     */
    protected static string $version = '1.0.0';

    /**
     * The plugin description.
     */
    protected static string $description = 'Laravilt plugin for Laravilt';

    /**
     * The plugin author.
     */
    protected static string $author = 'Fady Mondy';

    /**
     * Register the plugin with a Filament panel.
     *
     * This is where you register resources, pages, widgets, and other
     * Filament-specific components that should be available in the panel.
     */
    public function register(Panel $panel): void
    {
        // Register resources
        // $panel->resources([
        //     Resources\YourResource::class,
        // ]);

        // Register pages
        // $panel->pages([
        //     Pages\YourPage::class,
        // ]);

        // Register widgets
        // $panel->widgets([
        //     Widgets\StatsWidget::class,
        // ]);

        // Register render hooks
        // $panel->renderHook(
        //     'panels::body.end',
        //     fn () => view('laravilt::scripts')
        // );
    }

    /**
     * Boot the plugin for a panel.
     *
     * This method is called after the plugin is registered.
     * Use it for panel-specific initialization logic.
     */
    public function boot(Panel $panel): void
    {
        // Add panel-specific boot logic if needed
        // For example, register navigation items, custom themes, etc.
    }

    /**
     * Get the plugin ID.
     */
    public function getId(): string
    {
        return static::$id;
    }
}
