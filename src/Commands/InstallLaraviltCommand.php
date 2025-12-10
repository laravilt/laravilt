<?php

namespace Laravilt\Laravilt\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class InstallLaraviltCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'laravilt:install
                            {--force : Overwrite existing files}
                            {--skip-migrations : Skip running migrations}
                            {--skip-npm : Skip running npm install and build}';

    /**
     * The console command description.
     */
    protected $description = 'Install Laravilt admin panel and all its packages';

    /**
     * Laravilt packages in installation order.
     */
    protected array $packages = [
        'laravilt-support' => 'Support utilities and helpers',
        'laravilt-panel' => 'Admin panel core',
        'laravilt-auth' => 'Authentication system',
        'laravilt-forms' => 'Form builder components',
        'laravilt-tables' => 'Table builder components',
        'laravilt-actions' => 'Action system',
        'laravilt-schemas' => 'Schema definitions',
        'laravilt-infolists' => 'Information list components',
        'laravilt-notifications' => 'Notification system',
        'laravilt-widgets' => 'Dashboard widgets',
        'laravilt-query-builder' => 'Query builder utilities',
        'laravilt-ai' => 'AI assistant features',
        'laravilt-plugins' => 'Plugin system',
    ];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->newLine();
        $this->components->info('🚀 Installing Laravilt Admin Panel...');
        $this->newLine();

        // Step 1: Publish all package configs
        $this->publishConfigs();

        // Step 2: Publish assets
        $this->publishAssets();

        // Step 3: Run migrations
        if (! $this->option('skip-migrations')) {
            $this->runMigrations();
        }

        // Step 4: Setup Vite aliases
        $this->setupViteAliases();

        // Step 5: Install npm dependencies and build
        if (! $this->option('skip-npm')) {
            $this->runNpmCommands();
        }

        // Step 6: Clear caches
        $this->clearCaches();

        $this->newLine();
        $this->components->info('✅ Laravilt has been installed successfully!');
        $this->newLine();

        $this->components->bulletList([
            'Run <fg=yellow>php artisan serve</> or use Laravel Herd',
            'Visit <fg=cyan>/admin</> to access the admin panel',
            'Run <fg=yellow>php artisan laravilt:make-user</> to create an admin user',
        ]);

        $this->newLine();

        return self::SUCCESS;
    }

    /**
     * Publish configuration files for all packages.
     */
    protected function publishConfigs(): void
    {
        $this->components->task('Publishing configurations', function () {
            foreach ($this->packages as $tag => $description) {
                $params = ['--tag' => "{$tag}-config"];

                if ($this->option('force')) {
                    $params['--force'] = true;
                }

                Artisan::call('vendor:publish', $params);
            }

            return true;
        });
    }

    /**
     * Publish frontend assets.
     */
    protected function publishAssets(): void
    {
        $this->components->task('Publishing frontend assets', function () {
            $tags = [
                'laravilt-panel-views',
                'laravilt-panel-assets',
                'laravilt-auth-views',
                'laravilt-ai-views',
            ];

            foreach ($tags as $tag) {
                $params = ['--tag' => $tag];

                if ($this->option('force')) {
                    $params['--force'] = true;
                }

                Artisan::call('vendor:publish', $params);
            }

            return true;
        });
    }

    /**
     * Run database migrations.
     */
    protected function runMigrations(): void
    {
        $this->components->task('Running migrations', function () {
            Artisan::call('migrate', ['--force' => true]);
            return true;
        });
    }

    /**
     * Setup Vite aliases for package components.
     */
    protected function setupViteAliases(): void
    {
        $this->components->task('Checking Vite configuration', function () {
            $viteConfigPath = base_path('vite.config.ts');

            if (! File::exists($viteConfigPath)) {
                return false;
            }

            $content = File::get($viteConfigPath);

            // Check if Laravilt aliases are already configured
            if (str_contains($content, '@laravilt/')) {
                return true; // Already configured
            }

            $this->components->warn('Please add Laravilt aliases to your vite.config.ts');

            return true;
        });
    }

    /**
     * Run npm install and build commands.
     */
    protected function runNpmCommands(): void
    {
        if (! $this->confirm('Would you like to install npm dependencies and build assets?', true)) {
            return;
        }

        $this->components->task('Installing npm dependencies', function () {
            exec('npm install 2>&1', $output, $exitCode);
            return $exitCode === 0;
        });

        $this->components->task('Building assets', function () {
            exec('npm run build 2>&1', $output, $exitCode);
            return $exitCode === 0;
        });
    }

    /**
     * Clear application caches.
     */
    protected function clearCaches(): void
    {
        $this->components->task('Clearing caches', function () {
            Artisan::call('config:clear');
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');

            return true;
        });
    }
}
