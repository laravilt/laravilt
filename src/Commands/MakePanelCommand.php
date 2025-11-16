<?php

declare(strict_types=1);

namespace Laravilt\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\text;

class MakePanelCommand extends Command
{
    protected $signature = 'laravilt:panel {name? : The panel name}
                            {--path= : The URL path for the panel}
                            {--id= : The panel ID}
                            {--force : Overwrite existing files}';

    protected $description = 'Create a new Laravilt panel provider';

    public function handle(): int
    {
        // Get panel name
        $name = $this->argument('name') ?? text(
            label: 'Panel name (e.g., Admin, Client, Vendor)',
            placeholder: 'Admin',
            required: true
        );

        // Convert to StudlyCase and ensure it ends with "Panel"
        $studlyName = Str::studly($name);
        if (! str_ends_with($studlyName, 'Panel')) {
            $studlyName .= 'Panel';
        }

        $providerName = $studlyName.'Provider';
        $panelName = str_replace('Panel', '', $studlyName);

        // Get panel ID (lowercase, no spaces)
        $panelId = $this->option('id') ?? Str::kebab($panelName);

        // Get panel path
        $defaultPath = $panelId;
        $panelPath = $this->option('path') ?? text(
            label: 'Panel URL path',
            placeholder: $defaultPath,
            default: $defaultPath,
            required: true
        );

        // Confirm resource directory
        $resourceDir = text(
            label: 'Resources directory',
            placeholder: "app/Laravilt/{$panelName}",
            default: "app/Laravilt/{$panelName}",
            required: true
        );

        // Convert directory path to namespace (remove 'app/' prefix first, then convert to namespace)
        $resourceNamespace = str_replace('app/', '', $resourceDir);
        $resourceNamespace = 'App\\'.str_replace('/', '\\', $resourceNamespace);

        // Generate the panel provider
        $this->generatePanelProvider($providerName, $panelId, $panelPath, $resourceDir, $resourceNamespace);

        // Create resource directory
        $fullResourcePath = base_path($resourceDir);

        if (! File::isDirectory($fullResourcePath)) {
            File::makeDirectory($fullResourcePath, 0755, true);
            $this->components->task("Created directory: {$resourceDir}");
        }

        // Register provider
        $this->registerPanelProvider($providerName);

        $this->newLine();
        $this->components->info("Panel '{$panelName}' created successfully! 🎉");
        $this->newLine();

        $this->components->info('Next steps:');
        $this->components->bulletList([
            'Visit: '.config('app.url')."/{$panelPath}",
            "Create resources in: {$resourceDir}",
            "Configure in: app/Providers/Laravilt/{$providerName}.php",
        ]);

        return self::SUCCESS;
    }

    protected function generatePanelProvider(
        string $providerName,
        string $panelId,
        string $panelPath,
        string $resourceDir,
        string $resourceNamespace
    ): void {
        $providerPath = app_path("Providers/Laravilt/{$providerName}.php");

        if (File::exists($providerPath) && ! $this->option('force')) {
            $this->components->warn("Provider {$providerName} already exists. Use --force to overwrite.");

            return;
        }

        // Ensure directory exists
        $providerDir = dirname($providerPath);
        if (! File::isDirectory($providerDir)) {
            File::makeDirectory($providerDir, 0755, true);
        }

        // Strip 'app/' prefix from resourceDir since app_path() already adds it
        $resourceDirForAppPath = ltrim(str_replace('app/', '', $resourceDir), '/');

        $stub = <<<PHP
<?php

namespace App\Providers\Laravilt;

use Laravilt\Panel\Panel;
use Laravilt\Panel\PanelProvider;

class {$providerName} extends PanelProvider
{
    public function panel(): Panel
    {
        return Panel::make('{$panelId}')
            ->path('{$panelPath}')
            ->discoverResources(
                in: app_path('{$resourceDirForAppPath}'),
                for: '{$resourceNamespace}'
            );
    }
}

PHP;

        File::put($providerPath, $stub);
        $this->components->task("Created {$providerName}");
    }

    protected function registerPanelProvider(string $providerName): void
    {
        $providersPath = base_path('bootstrap/providers.php');

        if (! File::exists($providersPath)) {
            $this->components->warn('Could not find bootstrap/providers.php');

            return;
        }

        $content = File::get($providersPath);

        // Check if already registered
        if (str_contains($content, $providerName.'::class')) {
            $this->components->info("{$providerName} already registered");

            return;
        }

        // Add to providers array
        $search = "return [\n";
        $replace = "return [\n    App\\Providers\\Laravilt\\{$providerName}::class,\n";

        if (str_contains($content, $search)) {
            $content = str_replace($search, $replace, $content);
            File::put($providersPath, $content);
            $this->components->task("Registered {$providerName}");
        } else {
            $this->components->warn("Could not automatically register {$providerName}. Please add it to bootstrap/providers.php manually.");
        }
    }
}
