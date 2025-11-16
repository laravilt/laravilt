<?php

declare(strict_types=1);

namespace Laravilt\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class UpdateCommand extends Command
{
    protected $signature = 'laravilt:update
                            {--all : Update all components}
                            {--layouts : Update layouts}
                            {--pages : Update pages}
                            {--components : Update components}
                            {--middleware : Update middleware}
                            {--panel : Update panel resources}
                            {--config : Update configuration files}
                            {--backup : Create backup before updating}
                            {--force : Force update without confirmation}';

    protected $description = 'Update Laravilt Framework components';

    protected array $backupPaths = [];

    public function handle(): int
    {
        $this->components->info('Laravilt Framework Updater');
        $this->newLine();

        // Check if any specific option is selected
        $hasSpecificOption = $this->option('layouts')
            || $this->option('pages')
            || $this->option('components')
            || $this->option('middleware')
            || $this->option('panel')
            || $this->option('config');

        // If no specific option, ask what to update or use --all
        if (! $hasSpecificOption && ! $this->option('all')) {
            if ($this->option('no-interaction')) {
                $this->components->error('Please specify what to update using options or use --all');

                return self::FAILURE;
            }

            $this->components->warn('No specific update option provided.');
            $this->newLine();

            $choices = $this->choice(
                'What would you like to update?',
                [
                    'all' => 'Update everything',
                    'layouts' => 'Layouts only',
                    'pages' => 'Pages only',
                    'components' => 'Components only',
                    'middleware' => 'Middleware only',
                    'panel' => 'Panel resources only',
                    'config' => 'Configuration only',
                ],
                'all',
                multiple: true
            );

            // Set options based on choices
            if (in_array('all', $choices)) {
                $this->input->setOption('all', true);
            } else {
                foreach ($choices as $choice) {
                    $this->input->setOption($choice, true);
                }
            }
        }

        // Create backup if requested or if not using --force
        if ($this->option('backup') || (! $this->option('force') && ! $this->option('no-interaction'))) {
            if ($this->option('no-interaction') || $this->confirm('Create backup before updating?', true)) {
                $this->createBackup();
            }
        }

        // Confirm update
        if (! $this->option('force') && ! $this->option('no-interaction')) {
            if (! $this->confirm('This will overwrite existing files. Continue?', true)) {
                $this->components->info('Update cancelled.');

                return self::SUCCESS;
            }
        }

        $this->newLine();
        $this->components->info('Updating Laravilt components...');
        $this->newLine();

        // Update based on options
        if ($this->option('all') || $this->option('layouts')) {
            $this->updateLayouts();
        }

        if ($this->option('all') || $this->option('pages')) {
            $this->updatePages();
        }

        if ($this->option('all') || $this->option('components')) {
            $this->updateComponents();
        }

        if ($this->option('all') || $this->option('middleware')) {
            $this->updateMiddleware();
        }

        if ($this->option('all') || $this->option('panel')) {
            $this->updatePanel();
        }

        if ($this->option('all') || $this->option('config')) {
            $this->updateConfig();
        }

        $this->newLine();
        $this->components->info('Update completed successfully! 🎉');

        if (! empty($this->backupPaths)) {
            $this->newLine();
            $this->components->info('Backup files created:');
            foreach ($this->backupPaths as $path) {
                $this->components->bulletList([$path]);
            }
        }

        $this->newLine();
        $this->components->info('Next steps:');
        $this->components->bulletList([
            'Run `npm run build` to rebuild your assets',
            'Test your application thoroughly',
            'If something went wrong, restore from backup',
        ]);

        return self::SUCCESS;
    }

    protected function createBackup(): void
    {
        $timestamp = now()->format('Y-m-d_His');
        $backupDir = storage_path("laravilt/backups/{$timestamp}");

        if (! File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        $this->components->task('Creating backup', function () use ($backupDir, $timestamp) {
            // Backup resources/js
            if (File::exists(resource_path('js'))) {
                $target = "{$backupDir}/js";
                File::copyDirectory(resource_path('js'), $target);
                $this->backupPaths[] = "storage/laravilt/backups/{$timestamp}/js";
            }

            // Backup middleware
            if (File::exists(app_path('Http/Middleware/HandleInertiaRequests.php'))) {
                $target = "{$backupDir}/HandleInertiaRequests.php";
                File::copy(app_path('Http/Middleware/HandleInertiaRequests.php'), $target);
                $this->backupPaths[] = "storage/laravilt/backups/{$timestamp}/HandleInertiaRequests.php";
            }

            // Backup config
            if (File::exists(config_path('laravilt.php'))) {
                $target = "{$backupDir}/laravilt.php";
                File::copy(config_path('laravilt.php'), $target);
                $this->backupPaths[] = "storage/laravilt/backups/{$timestamp}/laravilt.php";
            }

            return true;
        });
    }

    protected function updateLayouts(): void
    {
        $this->components->task('Updating layouts', function () {
            // Get manifest to know which files to publish
            $manifestPath = __DIR__.'/../../stubs/vue-starter-kit/manifest.json';

            if (! File::exists($manifestPath)) {
                return false;
            }

            $manifest = json_decode(File::get($manifestPath), true);

            foreach ($manifest as $stub => $target) {
                // Only process layout files
                if (! str_starts_with($stub, 'js/layouts/')) {
                    continue;
                }

                $stubPath = __DIR__.'/../../stubs/vue-starter-kit/'.$stub;
                $targetPath = base_path($target);

                if (! File::exists($stubPath)) {
                    continue;
                }

                // Ensure target directory exists
                $targetDir = dirname($targetPath);
                if (! File::exists($targetDir)) {
                    File::makeDirectory($targetDir, 0755, true);
                }

                // Copy file (remove .stub extension)
                $content = File::get($stubPath);
                File::put($targetPath, $content);
            }

            return true;
        });
    }

    protected function updatePages(): void
    {
        $this->components->task('Updating pages', function () {
            $manifestPath = __DIR__.'/../../stubs/vue-starter-kit/manifest.json';

            if (! File::exists($manifestPath)) {
                return false;
            }

            $manifest = json_decode(File::get($manifestPath), true);

            foreach ($manifest as $stub => $target) {
                // Only process page files
                if (! str_starts_with($stub, 'js/pages/')) {
                    continue;
                }

                $stubPath = __DIR__.'/../../stubs/vue-starter-kit/'.$stub;
                $targetPath = base_path($target);

                if (! File::exists($stubPath)) {
                    continue;
                }

                $targetDir = dirname($targetPath);
                if (! File::exists($targetDir)) {
                    File::makeDirectory($targetDir, 0755, true);
                }

                $content = File::get($stubPath);
                File::put($targetPath, $content);
            }

            return true;
        });
    }

    protected function updateComponents(): void
    {
        $this->components->task('Updating components', function () {
            // Publish support package components (including EmptyState, etc.)
            $this->callSilent('vendor:publish', [
                '--tag' => 'laravilt-support',
                '--force' => true,
            ]);

            // Publish from manifest
            $manifestPath = __DIR__.'/../../stubs/vue-starter-kit/manifest.json';

            if (! File::exists($manifestPath)) {
                return true;
            }

            $manifest = json_decode(File::get($manifestPath), true);

            foreach ($manifest as $stub => $target) {
                // Only process component files
                if (! str_starts_with($stub, 'js/components/')) {
                    continue;
                }

                $stubPath = __DIR__.'/../../stubs/vue-starter-kit/'.$stub;
                $targetPath = base_path($target);

                if (! File::exists($stubPath)) {
                    continue;
                }

                $targetDir = dirname($targetPath);
                if (! File::exists($targetDir)) {
                    File::makeDirectory($targetDir, 0755, true);
                }

                $content = File::get($stubPath);
                File::put($targetPath, $content);
            }

            return true;
        });
    }

    protected function updateMiddleware(): void
    {
        $this->components->task('Updating middleware', function () {
            $stubPath = __DIR__.'/../../stubs/HandleInertiaRequests.stub';
            $targetPath = app_path('Http/Middleware/HandleInertiaRequests.php');

            if (! File::exists($stubPath)) {
                return false;
            }

            File::copy($stubPath, $targetPath);

            return true;
        });
    }

    protected function updatePanel(): void
    {
        $this->components->task('Updating panel resources', function () {
            // Note: Panel pages/layouts/components are accessed via @laravilt/panel namespace
            // No need to publish them unless user has overridden them

            // Check if user has published overrides and update them if so
            if (File::exists(resource_path('js/pages/laravilt'))) {
                $this->callSilent('vendor:publish', [
                    '--tag' => 'laravilt-panel-pages-override',
                    '--force' => true,
                ]);
            }

            if (File::exists(resource_path('js/layouts/laravilt'))) {
                $this->callSilent('vendor:publish', [
                    '--tag' => 'laravilt-panel-layouts-override',
                    '--force' => true,
                ]);
            }

            if (File::exists(resource_path('js/components/laravilt'))) {
                $this->callSilent('vendor:publish', [
                    '--tag' => 'laravilt-panel-components-override',
                    '--force' => true,
                ]);
            }

            // Transform imports in published overrides if any
            if (File::exists(resource_path('js/pages/laravilt')) ||
                File::exists(resource_path('js/layouts/laravilt')) ||
                File::exists(resource_path('js/components/laravilt'))) {
                $this->transformImports();
            }

            return true;
        });
    }

    protected function transformImports(): void
    {
        $directories = [
            resource_path('js/components'),
            resource_path('js/layouts'),
            resource_path('js/pages'),
            resource_path('js/composables'),
        ];

        $replacements = [
            // Panel imports
            '@laravilt/panel/components/' => '@/components/laravilt/',
            '@laravilt/panel/layouts/' => '@/layouts/laravilt/',
            '@laravilt/panel/pages/' => '@/pages/laravilt/',

            // Support imports
            '@laravilt/support/components/' => '@/components/',
            '@laravilt/support/composables/' => '@/composables/',
            '@laravilt/support/lib/' => '@/lib/',
            '@laravilt/support/types' => '@/types',

            // Forms imports
            '@laravilt/forms/components/' => '@/components/laravilt/',
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
    }

    protected function updateConfig(): void
    {
        $this->components->task('Updating configuration', function () {
            $this->callSilent('vendor:publish', [
                '--tag' => 'laravilt-config',
                '--force' => true,
            ]);

            return true;
        });
    }
}
