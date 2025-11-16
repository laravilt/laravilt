<?php

declare(strict_types=1);

namespace Laravilt\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RestoreCommand extends Command
{
    protected $signature = 'laravilt:restore
                            {backup? : Backup timestamp to restore (e.g., 2024-01-15_143025)}
                            {--list : List available backups}';

    protected $description = 'Restore Laravilt files from backup';

    public function handle(): int
    {
        $backupDir = storage_path('laravilt/backups');

        if (! File::exists($backupDir)) {
            $this->components->error('No backups found.');

            return self::FAILURE;
        }

        // List backups if --list option is provided
        if ($this->option('list')) {
            return $this->listBackups($backupDir);
        }

        // Get backup timestamp
        $backup = $this->argument('backup');

        if (! $backup) {
            $backups = $this->getAvailableBackups($backupDir);

            if (empty($backups)) {
                $this->components->error('No backups available.');

                return self::FAILURE;
            }

            if ($this->option('no-interaction')) {
                $this->components->error('Please specify a backup timestamp.');
                $this->newLine();
                $this->components->info('Run `php artisan laravilt:restore --list` to see available backups.');

                return self::FAILURE;
            }

            $backup = $this->choice(
                'Select a backup to restore:',
                $backups,
                0
            );
        }

        $backupPath = "{$backupDir}/{$backup}";

        if (! File::exists($backupPath)) {
            $this->components->error("Backup not found: {$backup}");
            $this->newLine();
            $this->components->info('Run `php artisan laravilt:restore --list` to see available backups.');

            return self::FAILURE;
        }

        // Confirm restore
        if (! $this->option('no-interaction')) {
            $this->components->warn("This will restore files from backup: {$backup}");
            $this->newLine();

            if (! $this->confirm('Continue?', false)) {
                $this->components->info('Restore cancelled.');

                return self::SUCCESS;
            }
        }

        $this->newLine();
        $this->components->info('Restoring from backup...');
        $this->newLine();

        // Restore files
        $this->restoreFiles($backupPath);

        $this->newLine();
        $this->components->info('Restore completed successfully! 🎉');
        $this->newLine();
        $this->components->info('Next step:');
        $this->components->bulletList([
            'Run `npm run build` to rebuild your assets',
        ]);

        return self::SUCCESS;
    }

    protected function listBackups(string $backupDir): int
    {
        $backups = $this->getAvailableBackups($backupDir);

        if (empty($backups)) {
            $this->components->info('No backups available.');

            return self::SUCCESS;
        }

        $this->components->info('Available backups:');
        $this->newLine();

        foreach ($backups as $backup) {
            $backupPath = "{$backupDir}/{$backup}";
            $size = $this->getDirectorySize($backupPath);
            $this->components->bulletList(["{$backup} ({$size})"]);
        }

        $this->newLine();
        $this->components->info('To restore a backup, run:');
        $this->line('  php artisan laravilt:restore <backup-timestamp>');

        return self::SUCCESS;
    }

    protected function getAvailableBackups(string $backupDir): array
    {
        $directories = File::directories($backupDir);

        return array_map(function ($dir) {
            return basename($dir);
        }, $directories);
    }

    protected function restoreFiles(string $backupPath): void
    {
        // Restore resources/js
        if (File::exists("{$backupPath}/js")) {
            $this->components->task('Restoring resources/js', function () use ($backupPath) {
                $target = resource_path('js');

                // Remove existing directory
                if (File::exists($target)) {
                    File::deleteDirectory($target);
                }

                // Copy backup
                File::copyDirectory("{$backupPath}/js", $target);

                return true;
            });
        }

        // Restore HandleInertiaRequests middleware
        if (File::exists("{$backupPath}/HandleInertiaRequests.php")) {
            $this->components->task('Restoring HandleInertiaRequests middleware', function () use ($backupPath) {
                File::copy(
                    "{$backupPath}/HandleInertiaRequests.php",
                    app_path('Http/Middleware/HandleInertiaRequests.php')
                );

                return true;
            });
        }

        // Restore config
        if (File::exists("{$backupPath}/laravilt.php")) {
            $this->components->task('Restoring laravilt.php config', function () use ($backupPath) {
                File::copy(
                    "{$backupPath}/laravilt.php",
                    config_path('laravilt.php')
                );

                return true;
            });
        }
    }

    protected function getDirectorySize(string $path): string
    {
        $size = 0;
        $files = File::allFiles($path);

        foreach ($files as $file) {
            $size += $file->getSize();
        }

        return $this->formatBytes($size);
    }

    protected function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision).' '.$units[$i];
    }
}
