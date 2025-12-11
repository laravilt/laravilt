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
                            {--panel= : Create a panel with the given name (e.g., admin)}
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

        // Step 1: Publish package.json
        $this->publishPackageJson();

        // Step 2: Publish Vite config
        $this->publishViteConfig();

        // Step 3: Publish CSS
        $this->publishCss();

        // Step 4: Publish app.ts
        $this->publishAppTs();

        // Step 5: Publish app.blade.php
        $this->publishAppBlade();

        // Step 6: Publish middleware
        $this->publishMiddleware();

        // Step 7: Publish layouts
        $this->publishLayouts();

        // Step 8: Publish components
        $this->publishComponents();

        // Step 9: Publish UI components
        $this->publishUiComponents();

        // Step 10: Publish composables
        $this->publishComposables();

        // Step 11: Publish types
        $this->publishTypes();

        // Step 12: Publish User model
        $this->publishUserModel();

        // Step 13: Publish bootstrap files
        $this->publishBootstrap();

        // Step 14: Publish route files
        $this->publishRoutes();

        // Step 15: Delete settings folder (handled by auth package)
        $this->deleteSettingsFolder();

        // Step 16: Delete Dashboard.vue (panels have their own dashboard)
        $this->deleteDashboardPage();

        // Step 17: Publish Welcome.vue page
        $this->publishWelcomePage();

        // Step 18: Publish all package configs
        $this->publishConfigs();

        // Step 19: Publish assets
        $this->publishAssets();

        // Step 20: Run migrations
        if (! $this->option('skip-migrations')) {
            $this->runMigrations();
        }

        // Step 21: Install npm dependencies and build
        if (! $this->option('skip-npm')) {
            $this->runNpmCommands();
        }

        // Step 22: Clear caches
        $this->clearCaches();

        // Step 23: Create panel if --panel option provided
        $panelName = $this->option('panel');
        if ($panelName) {
            $this->createPanel($panelName);
        }

        $this->newLine();
        $this->components->info('✅ Laravilt has been installed successfully!');
        $this->newLine();

        $nextSteps = [
            'Run <fg=yellow>php artisan serve</> or use Laravel Herd',
            'Run <fg=yellow>php artisan laravilt:user</> to create an admin user',
        ];

        if (! $panelName) {
            array_splice($nextSteps, 1, 0, 'Run <fg=yellow>php artisan laravilt:panel admin</> to create your first panel');
        } else {
            $nextSteps[] = "Visit <fg=cyan>/{$panelName}</> to access the admin panel";
        }

        $this->components->bulletList($nextSteps);
        $this->newLine();

        // Ask user to rate the repo
        $this->askToRateRepo();

        return self::SUCCESS;
    }

    /**
     * Create a panel with the given name.
     */
    protected function createPanel(string $name): void
    {
        $this->components->task("Creating '{$name}' panel", function () use ($name) {
            Artisan::call('laravilt:panel', ['id' => $name]);

            return true;
        });
    }

    /**
     * Publish package.json.
     */
    protected function publishPackageJson(): void
    {
        $stubPath = $this->getStubPath('package.json.stub');
        $targetPath = base_path('package.json');

        if (File::exists($stubPath)) {
            $this->copyStub($stubPath, $targetPath);
        } else {
            // Create package.json inline if stub doesn't exist
            $this->createPackageJsonInline($targetPath);
        }
        $this->components->info('package.json published');
    }

    /**
     * Create package.json inline when stub is not available.
     */
    protected function createPackageJsonInline(string $targetPath): void
    {
        $content = <<<'JSON'
{
    "$schema": "https://www.schemastore.org/package.json",
    "private": true,
    "type": "module",
    "scripts": {
        "build": "vite build",
        "build:ssr": "vite build && vite build --ssr",
        "dev": "vite",
        "format": "prettier --write resources/",
        "format:check": "prettier --check resources/",
        "lint": "eslint . --fix"
    },
    "devDependencies": {
        "@eslint/js": "^9.19.0",
        "@laravel/vite-plugin-wayfinder": "^0.1.3",
        "@tailwindcss/vite": "^4.1.11",
        "@types/node": "^22.13.5",
        "@vitejs/plugin-vue": "^6.0.0",
        "@vue/eslint-config-typescript": "^14.3.0",
        "concurrently": "^9.0.1",
        "eslint": "^9.17.0",
        "eslint-config-prettier": "^10.0.1",
        "eslint-plugin-vue": "^9.32.0",
        "prettier": "^3.4.2",
        "prettier-plugin-organize-imports": "^4.1.0",
        "prettier-plugin-tailwindcss": "^0.6.11",
        "typescript": "^5.2.2",
        "typescript-eslint": "^8.23.0",
        "vite": "^7.0.4",
        "vue-tsc": "^2.2.4"
    },
    "dependencies": {
        "@codemirror/commands": "^6.10.0",
        "@codemirror/lang-css": "^6.3.1",
        "@codemirror/lang-html": "^6.4.11",
        "@codemirror/lang-javascript": "^6.2.4",
        "@codemirror/lang-json": "^6.0.2",
        "@codemirror/lang-php": "^6.0.2",
        "@codemirror/language": "^6.11.3",
        "@codemirror/state": "^6.5.2",
        "@codemirror/theme-one-dark": "^6.1.3",
        "@codemirror/view": "^6.38.8",
        "@inertiajs/vue3": "^2.1.0",
        "@laravilt/actions": "npm:@laravilt/actions@^1.0",
        "@laravilt/forms": "npm:@laravilt/forms@^1.0",
        "@laravilt/infolists": "npm:@laravilt/infolists@^1.0",
        "@laravilt/notifications": "npm:@laravilt/notifications@^1.0",
        "@laravilt/schemas": "npm:@laravilt/schemas@^1.0",
        "@laravilt/support": "npm:@laravilt/support@^1.0",
        "@laravilt/tables": "npm:@laravilt/tables@^1.0",
        "@laravilt/widgets": "npm:@laravilt/widgets@^1.0",
        "@tiptap/extension-color": "^3.11.0",
        "@tiptap/extension-highlight": "^3.11.0",
        "@tiptap/extension-image": "^3.11.0",
        "@tiptap/extension-link": "^3.11.0",
        "@tiptap/extension-placeholder": "^3.11.0",
        "@tiptap/extension-table": "^3.11.0",
        "@tiptap/extension-table-cell": "^3.11.0",
        "@tiptap/extension-table-header": "^3.11.0",
        "@tiptap/extension-table-row": "^3.11.0",
        "@tiptap/extension-text-align": "^3.11.0",
        "@tiptap/extension-text-style": "^3.11.0",
        "@tiptap/extension-underline": "^3.11.0",
        "@tiptap/starter-kit": "^3.11.0",
        "@tiptap/vue-3": "^3.11.0",
        "@vueuse/core": "^12.8.2",
        "class-variance-authority": "^0.7.1",
        "clsx": "^2.1.1",
        "codemirror": "^6.0.2",
        "cropperjs": "^1.6.2",
        "filepond": "^4.32.10",
        "filepond-plugin-file-validate-size": "^2.2.8",
        "filepond-plugin-file-validate-type": "^1.2.9",
        "filepond-plugin-image-preview": "^4.6.12",
        "laravel-vite-plugin": "^2.0.0",
        "lucide-vue-next": "^0.468.0",
        "markdown-it": "^14.1.0",
        "radix-vue": "^1.9.17",
        "reka-ui": "^2.6.1",
        "sortablejs": "^1.15.6",
        "tailwind-merge": "^3.2.0",
        "tailwindcss": "^4.1.1",
        "tw-animate-css": "^1.2.5",
        "vue": "^3.5.13",
        "vue-filepond": "^7.0.4"
    }
}
JSON;

        file_put_contents($targetPath, $content);
    }

    /**
     * Publish Vite configuration.
     */
    protected function publishViteConfig(): void
    {
        $stubPath = $this->getStubPath('vite.config.ts.stub');
        $targetPath = base_path('vite.config.ts');

        if (File::exists($stubPath)) {
            $this->copyStub($stubPath, $targetPath);
        } else {
            // Create vite config inline if stub doesn't exist
            $this->createViteConfigInline($targetPath);
        }
        $this->components->info('Vite config published');
    }

    /**
     * Create vite.config.ts inline when stub is not available.
     */
    protected function createViteConfigInline(string $targetPath): void
    {
        $content = <<<'VITE'
import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'path';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        tailwindcss(),
        wayfinder({
            formVariants: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': resolve(__dirname, 'resources/js'),
            '@laravilt/panel': resolve(__dirname, 'vendor/laravilt/panel/resources/js'),
            '@laravilt/widgets': resolve(__dirname, 'vendor/laravilt/widgets/resources/js'),
            '@laravilt/forms': resolve(__dirname, 'vendor/laravilt/forms/resources/js'),
            '@laravilt/tables': resolve(__dirname, 'vendor/laravilt/tables/resources/js'),
            '@laravilt/actions': resolve(__dirname, 'vendor/laravilt/actions/resources/js'),
            '@laravilt/infolists': resolve(__dirname, 'vendor/laravilt/infolists/resources/js'),
            '@laravilt/notifications': resolve(__dirname, 'vendor/laravilt/notifications/resources/js'),
            '@laravilt/schemas': resolve(__dirname, 'vendor/laravilt/schemas/resources/js'),
            '@laravilt/support': resolve(__dirname, 'vendor/laravilt/support/resources/js'),
            '@laravilt/auth': resolve(__dirname, 'vendor/laravilt/auth/resources/js'),
            '@laravilt/ai': resolve(__dirname, 'vendor/laravilt/ai/resources/js'),
        },
        dedupe: ['vue', '@inertiajs/vue3'],
    },
    optimizeDeps: {
        include: ['@inertiajs/vue3', 'vue'],
    },
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    'vue-vendor': ['vue', '@inertiajs/vue3'],
                },
            },
        },
    },
});
VITE;

        file_put_contents($targetPath, $content);
    }

    /**
     * Publish CSS files.
     */
    protected function publishCss(): void
    {
        $stubPath = $this->getStubPath('css/app.css.stub');
        $targetPath = resource_path('css/app.css');

        if (File::exists($stubPath)) {
            $this->copyStub($stubPath, $targetPath);
            $this->components->info('CSS published');
        }
    }

    /**
     * Publish app.ts file.
     */
    protected function publishAppTs(): void
    {
        $stubPath = $this->getStubPath('app.ts.stub');
        $targetPath = resource_path('js/app.ts');

        if (File::exists($stubPath)) {
            $this->copyStub($stubPath, $targetPath);
        } else {
            $this->createAppTsInline($targetPath);
        }
        $this->components->info('app.ts published');
    }

    /**
     * Create app.ts inline when stub is not available.
     */
    protected function createAppTsInline(string $targetPath): void
    {
        $content = <<<'TYPESCRIPT'
import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { initializeTheme } from './composables/useAppearance';
import { notify } from '@laravilt/notifications/app';
import LaraviltForms from '@laravilt/forms/app';
import LaraviltTables from '@laravilt/tables/app';
import LaraviltWidgets from '@laravilt/widgets/app';

// Make notify globally available
(window as any).notify = notify;

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: async (name) => {
        const appPages = import.meta.glob<DefineComponent>('./pages/**/*.vue');
        const panelPages = import.meta.glob<DefineComponent>('../vendor/laravilt/panel/resources/js/pages/**/*.vue');
        const authPages = import.meta.glob<DefineComponent>('../vendor/laravilt/auth/resources/js/Pages/**/*.vue');
        const aiPages = import.meta.glob<DefineComponent>('../vendor/laravilt/ai/resources/js/Pages/**/*.vue');

        if (name.startsWith('laravilt-auth/')) {
            const authPageName = name.replace('laravilt-auth/', '');
            return await resolvePageComponent(
                `../vendor/laravilt/auth/resources/js/Pages/${authPageName}.vue`,
                authPages,
            );
        }

        try {
            return await resolvePageComponent(`./pages/${name}.vue`, appPages);
        } catch (e) {
            try {
                return await resolvePageComponent(
                    `../vendor/laravilt/panel/resources/js/pages/${name}.vue`,
                    panelPages,
                );
            } catch (e2) {
               try {
                   return await resolvePageComponent(
                       `../vendor/laravilt/auth/resources/js/Pages/${name}.vue`,
                       authPages,
                   );
               } catch (e3) {
                   return await resolvePageComponent(
                       `../vendor/laravilt/ai/resources/js/Pages/${name}.vue`,
                       aiPages,
                   );
               }
            }
        }
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(LaraviltForms)
            .use(LaraviltTables)
            .use(LaraviltWidgets)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

initializeTheme();
TYPESCRIPT;

        $dir = dirname($targetPath);
        if (! File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }
        file_put_contents($targetPath, $content);
    }

    /**
     * Publish app.blade.php file.
     */
    protected function publishAppBlade(): void
    {
        $stubPath = $this->getStubPath('views/app.blade.php.stub');
        $targetPath = resource_path('views/app.blade.php');

        if (File::exists($stubPath)) {
            $this->copyStub($stubPath, $targetPath);
            $this->components->info('app.blade.php published');
        } else {
            $this->components->warn('app.blade.php stub not found');
        }
    }

    /**
     * Publish UI components from package.
     */
    protected function publishUiComponents(): void
    {
        $this->components->task('Publishing UI components', function () {
            // UI components are published via service provider tags
            Artisan::call('vendor:publish', [
                '--tag' => 'laravilt-panel-ui',
                '--force' => true,
            ]);

            return true;
        });
    }

    /**
     * Publish composables.
     */
    protected function publishComposables(): void
    {
        $composables = [
            'useAppearance.ts',
            'useInitials.ts',
            'useLocalization.ts',
            'useTwoFactorAuth.ts',
            'usePanelFont.ts',
        ];

        foreach ($composables as $composable) {
            $stubPath = $this->getStubPath("composables/{$composable}.stub");
            $targetPath = resource_path("js/composables/{$composable}");

            if (File::exists($stubPath)) {
                $this->copyStub($stubPath, $targetPath);
            }
        }

        $this->components->info('Composables published');
    }

    /**
     * Delete the settings folder (settings pages are handled by auth package).
     */
    protected function deleteSettingsFolder(): void
    {
        $settingsPath = resource_path('js/pages/settings');

        if (File::isDirectory($settingsPath)) {
            File::deleteDirectory($settingsPath);
            $this->components->info('Deleted settings folder (handled by auth package)');
        }
    }

    /**
     * Delete the Dashboard.vue page (panels create their own dashboard).
     */
    protected function deleteDashboardPage(): void
    {
        $dashboardPath = resource_path('js/pages/Dashboard.vue');

        if (File::exists($dashboardPath)) {
            File::delete($dashboardPath);
            $this->components->info('Deleted Dashboard.vue (panels have their own dashboard)');
        }
    }

    /**
     * Publish the Welcome.vue page.
     */
    protected function publishWelcomePage(): void
    {
        $stubPath = $this->getStubPath('pages/Welcome.vue.stub');
        $targetPath = resource_path('js/pages/Welcome.vue');

        if (File::exists($stubPath)) {
            $this->copyStub($stubPath, $targetPath);
            $this->components->info('Welcome.vue published');
        }
    }

    /**
     * Publish middleware files.
     */
    protected function publishMiddleware(): void
    {
        $this->copyStub(
            $this->getStubPath('Middleware/HandleInertiaRequests.stub'),
            app_path('Http/Middleware/HandleInertiaRequests.php')
        );

        $this->copyStub(
            $this->getStubPath('Middleware/HandleAppearance.stub'),
            app_path('Http/Middleware/HandleAppearance.php')
        );

        $this->components->info('Middleware published');
    }

    /**
     * Publish layout files.
     */
    protected function publishLayouts(): void
    {
        $layouts = [
            'AppLayout.vue',
            'AuthLayout.vue',
            'app/AppSidebarLayout.vue',
            'app/AppHeaderLayout.vue',
            'auth/AuthSimpleLayout.vue',
            'auth/AuthSplitLayout.vue',
            'auth/AuthCardLayout.vue',
            'settings/Layout.vue',
        ];

        foreach ($layouts as $layout) {
            $stubPath = $this->getStubPath("layouts/{$layout}.stub");
            $targetPath = resource_path("js/layouts/{$layout}");

            if (File::exists($stubPath)) {
                $this->copyStub($stubPath, $targetPath);
            }
        }

        $this->components->info('Layouts published');
    }

    /**
     * Publish bootstrap files.
     */
    protected function publishBootstrap(): void
    {
        $this->copyStub(
            $this->getStubPath('bootstrap/app.stub'),
            base_path('bootstrap/app.php')
        );
        $this->components->info('Bootstrap app.php published');

        $this->copyStub(
            $this->getStubPath('bootstrap/providers.stub'),
            base_path('bootstrap/providers.php')
        );
        $this->components->info('Bootstrap providers.php published');
    }

    /**
     * Publish route files.
     */
    protected function publishRoutes(): void
    {
        $this->copyStub(
            $this->getStubPath('routes/web.stub'),
            base_path('routes/web.php')
        );
        $this->components->info('Route web.php published');

        $this->copyStub(
            $this->getStubPath('routes/settings.stub'),
            base_path('routes/settings.php')
        );
        $this->components->info('Route settings.php published');
    }

    /**
     * Publish Vue components.
     */
    protected function publishComponents(): void
    {
        $components = [
            // Core layout components
            'AppSidebar.vue',
            'AppSidebarHeader.vue',
            'AppShell.vue',
            'AppContent.vue',
            'AppHeader.vue',
            'AppLogo.vue',
            'AppLogoIcon.vue',

            // Navigation components
            'NavMain.vue',
            'NavFooter.vue',
            'NavUser.vue',
            'Breadcrumbs.vue',

            // UI components
            'Heading.vue',
            'HeadingSmall.vue',
            'Icon.vue',
            'InputError.vue',
            'TextLink.vue',
            'UserInfo.vue',
            'UserMenuContent.vue',
            'PlaceholderPattern.vue',
            'AlertError.vue',
            'AppearanceTabs.vue',

            // Auth components
            'DeleteUser.vue',
            'TwoFactorRecoveryCodes.vue',
            'TwoFactorSetupModal.vue',
        ];

        foreach ($components as $component) {
            $stubPath = $this->getStubPath("components/{$component}.stub");
            $targetPath = resource_path("js/components/{$component}");

            if (File::exists($stubPath)) {
                $this->copyStub($stubPath, $targetPath);
            }
        }

        $this->components->info('Components published');
    }

    /**
     * Publish TypeScript type definitions.
     */
    protected function publishTypes(): void
    {
        $stubPath = $this->getStubPath('types/index.d.ts.stub');
        $targetPath = resource_path('js/types/index.d.ts');

        if (File::exists($stubPath)) {
            $this->copyStub($stubPath, $targetPath);
            $this->components->info('Types published');
        }
    }

    /**
     * Publish User model with LaraviltUser trait.
     */
    protected function publishUserModel(): void
    {
        $stubPath = $this->getStubPath('Models/User.php.stub');
        $targetPath = app_path('Models/User.php');

        if (File::exists($stubPath)) {
            $this->copyStub($stubPath, $targetPath);
            $this->components->info('User model published with LaraviltUser trait');
        }
    }

    /**
     * Publish configuration files for all packages.
     */
    protected function publishConfigs(): void
    {
        $this->components->task('Publishing configurations', function () {
            foreach ($this->packages as $tag => $description) {
                Artisan::call('vendor:publish', [
                    '--tag' => "{$tag}-config",
                    '--force' => true,
                ]);
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
                Artisan::call('vendor:publish', [
                    '--tag' => $tag,
                    '--force' => true,
                ]);
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

    /**
     * Get the path to a stub file from the panel package.
     */
    protected function getStubPath(string $stub): string
    {
        // Try vendor path first (for composer-installed packages)
        $vendorPath = base_path('vendor/laravilt/panel/stubs/'.$stub);
        if (File::exists($vendorPath)) {
            return $vendorPath;
        }

        // Try local packages path (for development)
        $localPath = base_path('packages/laravilt/panel/stubs/'.$stub);
        if (File::exists($localPath)) {
            return $localPath;
        }

        // Try relative to this package (for monorepo)
        $relativePath = dirname(__DIR__, 4).'/panel/stubs/'.$stub;
        if (File::exists($relativePath)) {
            return $relativePath;
        }

        return $vendorPath; // Return vendor path as default (will fail gracefully in copyStub)
    }

    /**
     * Copy a stub file to the target location.
     */
    protected function copyStub(string $from, string $to): void
    {
        $dir = dirname($to);

        if (! File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        if (File::exists($from)) {
            $content = file_get_contents($from);
            file_put_contents($to, $content);
        }
    }

    /**
     * Ask the user to rate the Laravilt repository.
     */
    protected function askToRateRepo(): void
    {
        $this->newLine();
        $this->components->info('⭐ If you like Laravilt, please consider giving us a star on GitHub!');
        $this->line('   <fg=cyan>https://github.com/laravilt/laravilt</>');
        $this->newLine();

        if ($this->confirm('Would you like to open the GitHub repository now?', false)) {
            $this->openUrl('https://github.com/laravilt/laravilt');
        }

        $this->newLine();
        $this->components->info('📚 Documentation: <fg=cyan>https://laravilt.com</>');
        $this->components->info('🐛 Report issues: <fg=cyan>https://github.com/laravilt/laravilt/issues</>');
        $this->newLine();
    }

    /**
     * Open a URL in the default browser.
     */
    protected function openUrl(string $url): void
    {
        $command = match (PHP_OS_FAMILY) {
            'Darwin' => 'open',
            'Windows' => 'start',
            default => 'xdg-open',
        };

        exec("{$command} {$url} 2>/dev/null &");
    }
}
