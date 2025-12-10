<?php

namespace Laravilt\Laravilt\Mcp\Tools;

use Illuminate\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Artisan;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class InstallLaraviltTool extends Tool
{
    /**
     * The tool's description.
     */
    protected string $description = 'Install and configure Laravilt admin panel. Publishes configs, runs migrations, and sets up frontend assets.';

    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $force = $request->get('force', false);
        $skipMigrations = $request->get('skip_migrations', false);
        $skipNpm = $request->get('skip_npm', true); // Default to skip in MCP context

        $params = [];

        if ($force) {
            $params['--force'] = true;
        }

        if ($skipMigrations) {
            $params['--skip-migrations'] = true;
        }

        if ($skipNpm) {
            $params['--skip-npm'] = true;
        }

        try {
            Artisan::call('laravilt:install', $params);
            $output = Artisan::output();

            return Response::text("Laravilt installation completed.\n\n".$output);
        } catch (\Exception $e) {
            return Response::text("Installation failed: {$e->getMessage()}");
        }
    }

    /**
     * Get the tool's input schema.
     *
     * @return array<string, \Illuminate\JsonSchema\JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'force' => $schema->boolean('Overwrite existing files')->default(false),
            'skip_migrations' => $schema->boolean('Skip running database migrations')->default(false),
            'skip_npm' => $schema->boolean('Skip npm install and build (recommended for MCP)')->default(true),
        ];
    }
}
