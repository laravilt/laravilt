<?php

declare(strict_types=1);

namespace Laravilt\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command
{
    protected $signature = 'laravilt:install
                            {--panels : Install with panel support}
                            {--fresh : Start with a fresh installation}';

    protected $description = 'Install Laravilt Framework';

    public function handle(): int
    {
        $withPanels = $this->option('panels') || (! $this->option('no-interaction') && $this->confirm('Install with panel support?', true));

        $this->components->info('Installing Laravilt Framework'.($withPanels ? ' with Panels' : '').'...');

        // Check if Vue starter kit is installed
        if (! $this->isVueStarterKitInstalled()) {
            $this->components->warn('Vue starter kit not detected.');

            if ($this->option('no-interaction') || $this->confirm('Would you like to install Laravel Vue starter kit (Breeze)?', true)) {
                $this->installVueStarterKit();
            } else {
                $this->components->error('Laravilt requires Laravel Vue starter kit to be installed.');

                return self::FAILURE;
            }
        } else {
            $this->components->info('Vue starter kit detected');
        }

        // Install Vite plugin
        $this->publishVitePlugin();

        // Update vite.config.ts
        $this->updateViteConfig();

        // Update package.json
        $this->updatePackageJson();

        // Publish configuration
        $this->call('vendor:publish', [
            '--tag' => 'laravilt-config',
            '--force' => $this->option('fresh'),
        ]);

        $this->components->task('Configuration published');

        // Create directory structure
        $this->createDirectoryStructure($withPanels);

        if ($withPanels) {
            // Publish PanelServiceProvider
            $this->publishPanelProvider();

            // Publish panel routes
            $this->publishPanelRoutes();

            // Register routes in bootstrap/app.php
            $this->registerRoutes();

            // Publish panel frontend assets
            $this->publishPanelFrontend();

            // Create example Resource
            if ($this->option('fresh') || (! $this->option('no-interaction') && $this->confirm('Would you like to create an example User resource?', true))) {
                $this->call('laravilt:resource', ['name' => 'UserResource']);
            }
        }

        $this->newLine();
        $this->components->info('Laravilt installed successfully! 🎉');
        $this->newLine();

        if ($withPanels) {
            $this->components->info('Next steps:');
            $this->components->bulletList([
                'Configure your panel in app/Providers/Laravilt/DashboardPanelProvider.php',
                'Create resources using: php artisan laravilt:resource YourResource',
                'Run: npm install && npm run dev',
                'Visit: '.config('app.url').'/dashboard',
            ]);
        } else {
            $this->components->info('Next steps:');
            $this->components->bulletList([
                'Create resources using: php artisan laravilt:resource YourResource',
                'Run: npm install && npm run dev',
            ]);
        }

        return self::SUCCESS;
    }

    protected function createDirectoryStructure(bool $withPanels = false): void
    {
        $directories = [
            app_path('Laravilt'),
        ];

        if ($withPanels) {
            $directories = array_merge($directories, [
                app_path('Laravilt/Resources'),
                app_path('Laravilt/Pages'),
            ]);
        }

        foreach ($directories as $directory) {
            if (! File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true);
                $this->components->task("Created {$directory}");
            }
        }
    }

    protected function publishPanelProvider(): void
    {
        // Create Laravilt providers directory
        $laraviltProvidersDir = app_path('Providers/Laravilt');

        if (! File::isDirectory($laraviltProvidersDir)) {
            File::makeDirectory($laraviltProvidersDir, 0755, true);
        }

        // Copy DashboardPanelProvider stub
        $stubPath = base_path('packages/laravilt/panel/stubs/DashboardPanelProvider.stub');
        $targetPath = app_path('Providers/Laravilt/DashboardPanelProvider.php');

        if (! File::exists($targetPath) || $this->option('fresh')) {
            if (File::exists($stubPath)) {
                File::copy($stubPath, $targetPath);
                $this->components->task('Published DashboardPanelProvider');
            } else {
                $this->components->warn('Could not find DashboardPanelProvider stub at: '.$stubPath);

                return;
            }
        } else {
            $this->components->info('DashboardPanelProvider already exists');
        }

        // Register provider in bootstrap/providers.php
        $this->registerPanelProvider('DashboardPanelProvider');
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

    protected function publishPanelRoutes(): void
    {
        $routesStub = <<<'PHP'
<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Laravilt Panel Routes
|--------------------------------------------------------------------------
|
| Panel routes are automatically registered by the PanelServiceProvider.
| You can customize panel configuration in app/Providers/PanelServiceProvider.php
|
*/

// Routes are registered via PanelServiceProvider

PHP;

        $routesPath = base_path('routes/laravilt.php');

        if (! File::exists($routesPath) || $this->option('fresh')) {
            File::put($routesPath, $routesStub);
            $this->components->task('Published panel routes file');
        }
    }

    protected function registerRoutes(): void
    {
        $bootstrapPath = base_path('bootstrap/app.php');
        $content = File::get($bootstrapPath);

        // Check if laravilt routes are already registered
        if (str_contains($content, 'routes/laravilt.php')) {
            return;
        }

        // Add laravilt routes to withRouting method
        $search = "->withRouting(\n        web: __DIR__.'/../routes/web.php',";
        $replace = "->withRouting(\n        web: __DIR__.'/../routes/web.php',\n        then: function () {\n            if (file_exists(base_path('routes/laravilt.php'))) {\n                require base_path('routes/laravilt.php');\n            }\n        },";

        if (str_contains($content, $search)) {
            $content = str_replace($search, $replace, $content);
            File::put($bootstrapPath, $content);
            $this->components->task('Registered Laravilt routes in bootstrap/app.php');
        } else {
            $this->components->warn('Could not automatically register routes. Please add routes/laravilt.php to bootstrap/app.php manually.');
        }
    }

    protected function publishPanelFrontend(): void
    {
        // Publish panel pages
        $this->call('vendor:publish', [
            '--tag' => 'laravilt-panel-pages',
            '--force' => $this->option('fresh'),
        ]);

        // Publish panel layouts
        $this->call('vendor:publish', [
            '--tag' => 'laravilt-panel-layouts',
            '--force' => $this->option('fresh'),
        ]);

        // Publish panel components
        $this->call('vendor:publish', [
            '--tag' => 'laravilt-panel-components',
            '--force' => $this->option('fresh'),
        ]);

        // Publish support components (UI library, composables, types)
        $this->call('vendor:publish', [
            '--tag' => 'laravilt-support',
            '--force' => $this->option('fresh'),
        ]);

        // Publish forms components
        $this->call('vendor:publish', [
            '--tag' => 'laravilt-forms-components',
            '--force' => $this->option('fresh'),
        ]);

        $this->components->task('Published frontend assets');

        // Rewrite imports in published files
        $this->rewriteImports();
    }

    protected function publishVitePlugin(): void
    {
        // Create vite-plugins directory
        $vitePluginsDir = base_path('vite-plugins');

        if (! File::isDirectory($vitePluginsDir)) {
            File::makeDirectory($vitePluginsDir, 0755, true);
        }

        // Copy laravilt-packages plugin
        $stubPath = __DIR__.'/../../stubs/vite-plugins/laravilt-packages.ts.stub';
        $targetPath = base_path('vite-plugins/laravilt-packages.ts');

        if (! File::exists($targetPath) || $this->option('fresh')) {
            if (File::exists($stubPath)) {
                File::copy($stubPath, $targetPath);
                $this->components->task('Published Vite plugin');
            } else {
                $this->components->warn('Could not find Vite plugin stub');
            }
        }
    }

    protected function updateViteConfig(): void
    {
        $viteConfigPath = base_path('vite.config.ts');

        if (! File::exists($viteConfigPath)) {
            $this->components->warn('vite.config.ts not found');

            return;
        }

        $content = File::get($viteConfigPath);

        // Check if already configured
        if (str_contains($content, 'laraviltPackages')) {
            $this->components->info('vite.config.ts already configured');

            return;
        }

        // Add import
        if (! str_contains($content, "from './vite-plugins/laravilt-packages'")) {
            $content = str_replace(
                "import { defineConfig } from 'vite';",
                "import { defineConfig } from 'vite';\nimport { laraviltPackages } from './vite-plugins/laravilt-packages';",
                $content
            );
        }

        // Add plugin to plugins array
        $content = preg_replace(
            '/(plugins:\s*\[)/s',
            "$1\n        laraviltPackages(),",
            $content,
            1
        );

        File::put($viteConfigPath, $content);
        $this->components->task('Updated vite.config.ts');
    }

    protected function updatePackageJson(): void
    {
        $packageJsonPath = base_path('package.json');

        if (! File::exists($packageJsonPath)) {
            // Create basic package.json
            $packageJson = [
                'type' => 'module',
                'private' => true,
                'dependencies' => [],
                'devDependencies' => [],
                'scripts' => [],
            ];
        } else {
            $packageJson = json_decode(File::get($packageJsonPath), true);
        }

        // Define required dependencies
        $requiredDependencies = [
            // Core Vue/Inertia
            '@inertiajs/vue3' => '^2.0.0',
            '@vitejs/plugin-vue' => '^6.0.0',
            '@vue/server-renderer' => '^3.5.0',
            'vue' => '^3.5.0',
            'axios' => '^1.7.0',

            // Laravilt UI dependencies
            'class-variance-authority' => '^0.7.1',
            'clsx' => '^2.1.1',
            'lucide-vue-next' => '^0.468.0',
            'radix-vue' => '^1.9.11',
            'reka-ui' => '^0.4.0',
            'tailwind-merge' => '^2.5.5',
            'vaul-vue' => '^0.4.0',
        ];

        $requiredDevDependencies = [
            '@types/node' => '^22.0.0',
            'laravel-vite-plugin' => '^1.1.0',
            'tailwindcss' => '^4.0.0',
            'typescript' => '^5.6.0',
            'vite' => '^7.0.0',
            'vue-tsc' => '^2.2.0',
        ];

        $newDependencies = false;

        // Ensure dependencies object exists
        if (! isset($packageJson['dependencies'])) {
            $packageJson['dependencies'] = [];
        }

        foreach ($requiredDependencies as $package => $version) {
            if (! isset($packageJson['dependencies'][$package])) {
                $packageJson['dependencies'][$package] = $version;
                $newDependencies = true;
            }
        }

        // Ensure devDependencies object exists
        if (! isset($packageJson['devDependencies'])) {
            $packageJson['devDependencies'] = [];
        }

        foreach ($requiredDevDependencies as $package => $version) {
            if (! isset($packageJson['devDependencies'][$package])) {
                $packageJson['devDependencies'][$package] = $version;
                $newDependencies = true;
            }
        }

        // Add scripts if not present
        if (! isset($packageJson['scripts'])) {
            $packageJson['scripts'] = [];
        }

        $requiredScripts = [
            'dev' => 'vite',
            'build' => 'vue-tsc && vite build && vite build --ssr',
        ];

        foreach ($requiredScripts as $script => $command) {
            if (! isset($packageJson['scripts'][$script])) {
                $packageJson['scripts'][$script] = $command;
                $newDependencies = true;
            }
        }

        if ($newDependencies) {
            File::put(
                $packageJsonPath,
                json_encode($packageJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)."\n"
            );
            $this->components->task('Updated package.json');
            $this->components->info('Run "npm install" to install new dependencies');
        } else {
            $this->components->info('package.json already has required dependencies');
        }
    }

    protected function isVueStarterKitInstalled(): bool
    {
        // Check for key indicators that Vue starter kit is installed
        return File::exists(base_path('resources/js/app.ts'))
            && File::exists(base_path('resources/js/ssr.ts'))
            && File::exists(base_path('vite.config.ts'))
            && str_contains(File::get(base_path('vite.config.ts')), '@vitejs/plugin-vue');
    }

    protected function installVueStarterKit(): void
    {
        $this->components->info('Setting up Vue + Inertia...');

        // Ensure Inertia is installed
        if (! File::exists(base_path('vendor/inertiajs/inertia-laravel'))) {
            $this->components->task('Installing Inertia');
            exec('composer require inertiajs/inertia-laravel', $output, $returnCode);

            if ($returnCode !== 0) {
                $this->components->error('Failed to install Inertia');

                return;
            }
        }

        // Publish middleware
        $this->call('inertia:middleware', ['--no-interaction' => true]);

        // Create basic Vue setup structure
        $this->createVueSetup();

        $this->components->task('Vue + Inertia setup completed');
    }

    protected function createVueSetup(): void
    {
        $this->publishVueStarterKitBlueprint();
        $this->components->task('Created Vue setup files');
    }

    protected function publishVueStarterKitBlueprint(): void
    {
        $blueprintPath = __DIR__.'/../../stubs/vue-starter-kit';
        $manifestPath = $blueprintPath.'/manifest.json';

        if (! File::exists($manifestPath)) {
            $this->components->error('Vue starter kit blueprint manifest not found');

            return;
        }

        $manifest = json_decode(File::get($manifestPath), true);

        // Create required directories
        foreach ($manifest['directories']['required'] as $directory) {
            $fullPath = base_path($directory);
            if (! File::isDirectory($fullPath)) {
                File::makeDirectory($fullPath, 0755, true);
            }
        }

        // Copy files from blueprint
        foreach ($manifest['files'] as $source => $destination) {
            $sourcePath = $blueprintPath.'/'.$source;
            $destPath = base_path($destination);

            if (File::exists($sourcePath)) {
                // Read stub content
                $content = File::get($sourcePath);

                // Write to destination
                File::put($destPath, $content);
            }
        }
    }

    protected function rewriteImports(): void
    {
        $directories = [
            resource_path('js/Components'),
            resource_path('js/Layouts'),
            resource_path('js/Pages'),
            resource_path('js/composables'),
        ];

        $replacements = [
            // Panel imports
            '@laravilt/panel/components/' => '@/Components/laravilt/',
            '@laravilt/panel/layouts/' => '@/Layouts/laravilt/',
            '@laravilt/panel/pages/' => '@/Pages/laravilt/',

            // Support imports
            '@laravilt/support/components/' => '@/Components/',
            '@laravilt/support/composables/' => '@/composables/',
            '@laravilt/support/lib/' => '@/lib/',
            '@laravilt/support/types' => '@/types',

            // Forms imports
            '@laravilt/forms/components/' => '@/Components/laravilt/',

            // Fix case sensitivity - lowercase to uppercase
            '@/components/' => '@/Components/',
            '@/layouts/' => '@/Layouts/',
            '@/pages/' => '@/Pages/',
        ];

        foreach ($directories as $directory) {
            if (! File::isDirectory($directory)) {
                continue;
            }

            $files = File::allFiles($directory);

            foreach ($files as $file) {
                if (! in_array($file->getExtension(), ['vue', 'ts', 'js'])) {
                    continue;
                }

                $content = File::get($file->getPathname());
                $originalContent = $content;

                foreach ($replacements as $search => $replace) {
                    $content = str_replace($search, $replace, $content);
                }

                if ($content !== $originalContent) {
                    File::put($file->getPathname(), $content);
                }
            }
        }

        $this->components->task('Rewrote import paths');
    }
}
