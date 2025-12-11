<?php

namespace Laravilt\Laravilt\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class InstallLaraviltCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'laravilt:install
                            {--skip-migrations : Skip running migrations}
                            {--skip-npm : Skip running npm install and build}
                            {--skip-panel : Skip panel creation}';

    /**
     * The console command description.
     */
    protected $description = 'Install Laravilt admin panel and all its packages';

    /**
     * Panel configuration.
     */
    protected string $panelName = 'admin';

    protected array $panelFeatures = [];

    protected array $twoFactorProviders = [];

    protected array $socialProviders = [];

    protected string $aiModel = 'GPT_4O_MINI';

    protected bool $shouldCreateUser = false;

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
     * Available features for panels.
     */
    protected array $availableFeatures = [
        'login' => 'Login page',
        'registration' => 'User registration',
        'password-reset' => 'Password reset',
        'email-verification' => 'Email verification',
        'otp' => 'OTP authentication',
        'magic-links' => 'Magic link login',
        'two-factor' => 'Two-factor authentication (2FA)',
        'passkeys' => 'Passkey authentication (WebAuthn)',
        'session-management' => 'Session management',
        'profile' => 'User profile management',
        'social-login' => 'Social login (OAuth)',
        'connected-accounts' => 'Connected accounts',
        'api-tokens' => 'API tokens',
        'database-notifications' => 'Database notifications',
        'locale-timezone' => 'Locale & timezone settings',
        'global-search' => 'Global search',
        'ai-providers' => 'AI assistant',
    ];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->newLine();
        $this->components->info('Installing Laravilt Admin Panel...');
        $this->newLine();

        // ============================================
        // STEP 1: Gather all user input FIRST
        // ============================================
        $this->gatherUserInput();

        // ============================================
        // STEP 2: Run all non-interactive tasks
        // ============================================
        $this->newLine();
        $this->components->info('Publishing files...');
        $this->newLine();

        // Publish package.json
        $this->publishPackageJson();

        // Publish Vite config
        $this->publishViteConfig();

        // Publish CSS
        $this->publishCss();

        // Publish app.ts
        $this->publishAppTs();

        // Publish app.blade.php
        $this->publishAppBlade();

        // Publish middleware
        $this->publishMiddleware();

        // Publish layouts
        $this->publishLayouts();

        // Publish components
        $this->publishComponents();

        // Publish UI components
        $this->publishUiComponents();

        // Publish composables
        $this->publishComposables();

        // Publish types
        $this->publishTypes();

        // Publish User model
        $this->publishUserModel();

        // Publish bootstrap files
        $this->publishBootstrap();

        // Publish route files
        $this->publishRoutes();

        // Delete settings folder (handled by auth package)
        $this->deleteSettingsFolder();

        // Delete Dashboard.vue (panels have their own dashboard)
        $this->deleteDashboardPage();

        // Publish Welcome.vue page
        $this->publishWelcomePage();

        // Publish all package configs
        $this->publishConfigs();

        // Publish assets
        $this->publishAssets();

        // Run migrations
        if (! $this->option('skip-migrations')) {
            $this->runMigrations();
        }

        // Clear caches
        $this->clearCaches();

        // Create panel (using previously gathered input)
        if (! $this->option('skip-panel')) {
            $this->createPanel();
        }

        // Install npm dependencies and build
        if (! $this->option('skip-npm')) {
            $this->runNpmCommands();
        }

        // Create admin user (using previously gathered input)
        if ($this->shouldCreateUser) {
            $this->call('laravilt:user');
        }

        $this->newLine();
        $this->components->info('Laravilt has been installed successfully!');
        $this->newLine();

        $this->components->bulletList([
            'Run <fg=yellow>php artisan serve</> or use Laravel Herd',
            "Visit <fg=cyan>/{$this->panelName}</> to access the admin panel",
        ]);
        $this->newLine();

        // Ask user to rate the repo
        $this->askToRateRepo();

        return self::SUCCESS;
    }

    /**
     * Gather all user input at the beginning.
     */
    protected function gatherUserInput(): void
    {
        // Panel configuration
        if (! $this->option('skip-panel')) {
            $this->components->info('Panel Configuration');
            $this->newLine();

            // Ask for panel name
            $this->panelName = text(
                label: 'What is the panel identifier?',
                placeholder: 'admin',
                default: 'admin',
                required: true,
                hint: 'This will be used for the URL path (e.g., /admin)'
            );

            // Ask for features
            $this->newLine();
            $this->panelFeatures = multiselect(
                label: 'Which features would you like to enable?',
                options: $this->availableFeatures,
                default: ['login', 'password-reset', 'profile', 'database-notifications'],
                required: false,
                hint: 'Use space to select, enter to confirm',
                scroll: 12
            );

            // Ask for provider options based on selected features
            $this->askForProviderOptions();
        }

        // Ask about creating admin user
        $this->newLine();
        $this->shouldCreateUser = confirm(
            label: 'Would you like to create an admin user after installation?',
            default: true
        );
    }

    /**
     * Create panel using previously gathered configuration.
     */
    protected function createPanel(): void
    {
        $this->newLine();
        $this->components->info("Creating '{$this->panelName}' panel...");
        $this->newLine();

        // Create the panel provider
        $this->components->task("Creating '{$this->panelName}' panel provider", function () {
            $this->generatePanelProvider();

            return true;
        });

        // Create directories
        $this->components->task('Creating directories', function () {
            $studlyId = Str::studly($this->panelName);
            $basePath = app_path("Laravilt/{$studlyId}");

            foreach (['Pages', 'Widgets', 'Resources'] as $directory) {
                File::ensureDirectoryExists("{$basePath}/{$directory}");
            }

            return true;
        });

        // Create Dashboard page
        $this->components->task('Creating Dashboard page', function () {
            $this->createDashboardPage();

            return true;
        });

        // Register provider
        $this->components->task('Registering provider', function () {
            $this->registerProvider();

            return true;
        });

        // Run feature setup
        $this->runFeatureSetup();
    }

    /**
     * Ask for provider options based on selected features.
     */
    protected function askForProviderOptions(): void
    {
        // Two-factor providers
        if (in_array('two-factor', $this->panelFeatures)) {
            $this->newLine();
            $this->twoFactorProviders = multiselect(
                label: 'Which 2FA providers would you like to enable?',
                options: [
                    'totp' => 'TOTP (Authenticator App)',
                    'email' => 'Email verification code',
                ],
                default: ['totp', 'email'],
                required: true,
                hint: 'At least one provider is required for 2FA'
            );
        }

        // Social login providers
        if (in_array('social-login', $this->panelFeatures)) {
            $this->newLine();
            $this->socialProviders = multiselect(
                label: 'Which social login providers would you like to enable?',
                options: [
                    'google' => 'Google',
                    'github' => 'GitHub',
                    'facebook' => 'Facebook',
                    'twitter' => 'Twitter/X',
                    'linkedin' => 'LinkedIn',
                    'discord' => 'Discord',
                ],
                default: ['google', 'github'],
                required: true,
                hint: 'Select the OAuth providers you want to support'
            );
        }

        // AI model selection
        if (in_array('ai-providers', $this->panelFeatures)) {
            $this->newLine();
            $this->aiModel = select(
                label: 'Which AI model would you like to use?',
                options: [
                    'GPT_4O_MINI' => 'GPT-4o Mini (Recommended)',
                    'GPT_4O' => 'GPT-4o',
                    'GPT_4_TURBO' => 'GPT-4 Turbo',
                    'GPT_3_5_TURBO' => 'GPT-3.5 Turbo',
                ],
                default: 'GPT_4O_MINI',
                hint: 'GPT-4o Mini is recommended for most use cases'
            );
        }
    }

    /**
     * Generate panel provider with selected features.
     */
    protected function generatePanelProvider(): void
    {
        $studlyId = Str::studly($this->panelName);
        $imports = $this->buildImports();
        $authFeatures = $this->buildAuthFeatures();

        $content = <<<PHP
<?php

namespace App\Providers\Laravilt;

{$imports}use Laravilt\Panel\Panel;
use Laravilt\Panel\PanelProvider;

class {$studlyId}PanelProvider extends PanelProvider
{
    /**
     * Configure the panel.
     */
    public function panel(Panel \$panel): Panel
    {
        return \$panel
            ->id('{$this->panelName}')
            ->path('{$this->panelName}')
            ->brandName('{$studlyId}')
            ->discoverAutomatically()
{$authFeatures}            ->middleware(['web', 'auth'])
            ->authMiddleware(['auth']);
    }
}

PHP;

        $providerPath = app_path("Providers/Laravilt/{$studlyId}PanelProvider.php");
        File::ensureDirectoryExists(dirname($providerPath));
        File::put($providerPath, $content);
    }

    /**
     * Build imports based on selected features.
     */
    protected function buildImports(): string
    {
        $imports = [];

        if (in_array('two-factor', $this->panelFeatures) && ! empty($this->twoFactorProviders)) {
            $imports[] = 'use Laravilt\Auth\Builders\TwoFactorProviderBuilder;';
            if (in_array('totp', $this->twoFactorProviders)) {
                $imports[] = 'use Laravilt\Auth\Drivers\TotpDriver;';
            }
            if (in_array('email', $this->twoFactorProviders)) {
                $imports[] = 'use Laravilt\Auth\Drivers\EmailDriver;';
            }
        }

        if (in_array('social-login', $this->panelFeatures) && ! empty($this->socialProviders)) {
            $imports[] = 'use Laravilt\Auth\Builders\SocialProviderBuilder;';
            foreach ($this->socialProviders as $provider) {
                $class = $this->getSocialProviderClass($provider);
                $imports[] = "use Laravilt\\Auth\\Drivers\\SocialProviders\\{$class};";
            }
        }

        if (in_array('global-search', $this->panelFeatures)) {
            $imports[] = 'use Laravilt\AI\Builders\GlobalSearchBuilder;';
        }

        if (in_array('ai-providers', $this->panelFeatures)) {
            $imports[] = 'use Laravilt\AI\Builders\AIProviderBuilder;';
            $imports[] = 'use Laravilt\AI\Providers\OpenAIProvider;';
            $imports[] = 'use Laravilt\AI\Enums\OpenAIModel;';
        }

        if (empty($imports)) {
            return '';
        }

        sort($imports);

        return implode("\n", $imports)."\n";
    }

    /**
     * Get social provider class name.
     */
    protected function getSocialProviderClass(string $provider): string
    {
        return match ($provider) {
            'google' => 'GoogleProvider',
            'github' => 'GitHubProvider',
            'facebook' => 'FacebookProvider',
            'twitter' => 'TwitterProvider',
            'linkedin' => 'LinkedInProvider',
            'discord' => 'DiscordProvider',
            default => Str::studly($provider).'Provider',
        };
    }

    /**
     * Build authentication feature chain.
     */
    protected function buildAuthFeatures(): string
    {
        $methods = [];

        $simpleFeatures = [
            'login' => 'login',
            'registration' => 'registration',
            'password-reset' => 'passwordReset',
            'email-verification' => 'emailVerification',
            'otp' => 'otp',
            'magic-links' => 'magicLinks',
            'profile' => 'profile',
            'passkeys' => 'passkeys',
            'connected-accounts' => 'connectedAccounts',
            'session-management' => 'sessionManagement',
            'api-tokens' => 'apiTokens',
            'database-notifications' => 'databaseNotifications',
            'locale-timezone' => 'localeTimezone',
        ];

        foreach ($simpleFeatures as $feature => $method) {
            if (in_array($feature, $this->panelFeatures)) {
                $methods[] = "            ->{$method}()";
            }
        }

        if (in_array('two-factor', $this->panelFeatures) && ! empty($this->twoFactorProviders)) {
            $methods[] = $this->buildTwoFactorMethod();
        }

        if (in_array('social-login', $this->panelFeatures) && ! empty($this->socialProviders)) {
            $methods[] = $this->buildSocialLoginMethod();
        }

        if (in_array('global-search', $this->panelFeatures)) {
            $methods[] = "            ->globalSearch(function (GlobalSearchBuilder \$search) {\n                \$search->enabled()->limit(5)->debounce(300);\n            })";
        }

        if (in_array('ai-providers', $this->panelFeatures)) {
            $methods[] = "            ->aiProviders(function (AIProviderBuilder \$ai) {\n                \$ai->provider(OpenAIProvider::class, fn (OpenAIProvider \$p) => \$p->model(OpenAIModel::{$this->aiModel}))\n                   ->default('openai');\n            })";
        }

        return empty($methods) ? '' : implode("\n", $methods)."\n";
    }

    /**
     * Build two-factor method.
     */
    protected function buildTwoFactorMethod(): string
    {
        $providers = [];
        foreach ($this->twoFactorProviders as $provider) {
            $driver = $provider === 'totp' ? 'TotpDriver' : 'EmailDriver';
            $providers[] = "                \$builder->provider({$driver}::class);";
        }
        $providersCode = implode("\n", $providers);

        return "            ->twoFactor(builder: function (TwoFactorProviderBuilder \$builder) {\n{$providersCode}\n            })";
    }

    /**
     * Build social login method.
     */
    protected function buildSocialLoginMethod(): string
    {
        $providers = [];
        foreach ($this->socialProviders as $provider) {
            $class = $this->getSocialProviderClass($provider);
            $providers[] = "                \$builder->provider({$class}::class, fn ({$class} \$p) => \$p->enabled());";
        }
        $providersCode = implode("\n", $providers);

        return "            ->socialLogin(function (SocialProviderBuilder \$builder) {\n{$providersCode}\n            })";
    }

    /**
     * Create Dashboard page for the panel.
     */
    protected function createDashboardPage(): void
    {
        $studlyId = Str::studly($this->panelName);
        $stubPath = $this->getStubPath('dashboard.stub');

        if (File::exists($stubPath)) {
            $content = str_replace(
                ['{{ studlyId }}'],
                [$studlyId],
                File::get($stubPath)
            );
        } else {
            $content = <<<PHP
<?php

namespace App\Laravilt\\{$studlyId}\Pages;

use Laravilt\Panel\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string \$navigationIcon = 'LayoutDashboard';

    protected static ?int \$navigationSort = -2;
}
PHP;
        }

        $pagePath = app_path("Laravilt/{$studlyId}/Pages/Dashboard.php");
        File::ensureDirectoryExists(dirname($pagePath));
        File::put($pagePath, $content);
    }

    /**
     * Register provider in bootstrap/providers.php.
     */
    protected function registerProvider(): void
    {
        $studlyId = Str::studly($this->panelName);
        $provider = "App\\Providers\\Laravilt\\{$studlyId}PanelProvider::class";
        $providersFile = base_path('bootstrap/providers.php');

        if (! File::exists($providersFile)) {
            return;
        }

        $content = File::get($providersFile);

        if (str_contains($content, $provider)) {
            return;
        }

        $content = str_replace(
            'return [',
            "return [\n    {$provider},",
            $content
        );

        File::put($providersFile, $content);
    }

    /**
     * Run feature setup based on selected features.
     */
    protected function runFeatureSetup(): void
    {
        if (in_array('database-notifications', $this->panelFeatures)) {
            $this->components->task('Setting up database notifications', function () {
                $migrations = File::glob(database_path('migrations/*_create_notifications_table.php'));
                if (empty($migrations)) {
                    Artisan::call('notifications:table');
                }
                Artisan::call('migrate', ['--force' => true]);

                return true;
            });
        }

        if (in_array('passkeys', $this->panelFeatures)) {
            $this->components->task('Setting up passkeys', function () {
                $migrations = File::glob(database_path('migrations/*_create_web_authn_credentials_table.php'));
                if (empty($migrations)) {
                    Artisan::call('vendor:publish', ['--tag' => 'webauthn-migrations']);
                }
                Artisan::call('migrate', ['--force' => true]);

                return true;
            });
        }
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
        "@inertiajs/vue3": "^2.1.0",
        "@laravilt/actions": "npm:@laravilt/actions@^1.0",
        "@laravilt/forms": "npm:@laravilt/forms@^1.0",
        "@laravilt/infolists": "npm:@laravilt/infolists@^1.0",
        "@laravilt/notifications": "npm:@laravilt/notifications@^1.0",
        "@laravilt/schemas": "npm:@laravilt/schemas@^1.0",
        "@laravilt/support": "npm:@laravilt/support@^1.0",
        "@laravilt/tables": "npm:@laravilt/tables@^1.0",
        "@laravilt/widgets": "npm:@laravilt/widgets@^1.0",
        "@vueuse/core": "^12.8.2",
        "class-variance-authority": "^0.7.1",
        "clsx": "^2.1.1",
        "laravel-vite-plugin": "^2.0.0",
        "lucide-vue-next": "^0.468.0",
        "radix-vue": "^1.9.17",
        "reka-ui": "^2.6.1",
        "tailwind-merge": "^3.2.0",
        "tailwindcss": "^4.1.1",
        "tw-animate-css": "^1.2.5",
        "vue": "^3.5.13"
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
        wayfinder({ formVariants: true }),
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
        },
        dedupe: ['vue', '@inertiajs/vue3'],
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
        }
        $this->components->info('app.ts published');
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
        }
    }

    /**
     * Publish UI components from package.
     */
    protected function publishUiComponents(): void
    {
        $this->components->task('Publishing UI components', function () {
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
     * Delete the settings folder.
     */
    protected function deleteSettingsFolder(): void
    {
        $settingsPath = resource_path('js/pages/settings');

        if (File::isDirectory($settingsPath)) {
            File::deleteDirectory($settingsPath);
            $this->components->info('Deleted settings folder');
        }
    }

    /**
     * Clean up pages folder - keep only Welcome.vue.
     */
    protected function deleteDashboardPage(): void
    {
        $pagesPath = resource_path('js/pages');

        if (! File::isDirectory($pagesPath)) {
            return;
        }

        $deleted = false;

        // Delete all files except Welcome.vue
        $files = File::files($pagesPath);
        foreach ($files as $file) {
            if ($file->getFilename() !== 'Welcome.vue') {
                File::delete($file->getPathname());
                $deleted = true;
            }
        }

        // Delete all subdirectories (panels will create their own pages)
        $directories = File::directories($pagesPath);
        foreach ($directories as $directory) {
            File::deleteDirectory($directory);
            $deleted = true;
        }

        if ($deleted) {
            $this->components->info('Cleaned up pages folder');
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
            'AppSidebar.vue',
            'AppSidebarHeader.vue',
            'AppShell.vue',
            'AppContent.vue',
            'AppHeader.vue',
            'AppLogo.vue',
            'AppLogoIcon.vue',
            'NavMain.vue',
            'NavFooter.vue',
            'NavUser.vue',
            'Breadcrumbs.vue',
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
            $this->components->info('User model published');
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
        $this->newLine();
        $this->components->info('Installing npm dependencies and building assets...');

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
            Artisan::call('optimize:clear');

            return true;
        });
    }

    /**
     * Get the path to a stub file.
     */
    protected function getStubPath(string $stub): string
    {
        $vendorPath = base_path('vendor/laravilt/panel/stubs/'.$stub);
        if (File::exists($vendorPath)) {
            return $vendorPath;
        }

        $localPath = base_path('packages/laravilt/panel/stubs/'.$stub);
        if (File::exists($localPath)) {
            return $localPath;
        }

        $relativePath = dirname(__DIR__, 4).'/panel/stubs/'.$stub;
        if (File::exists($relativePath)) {
            return $relativePath;
        }

        return $vendorPath;
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
        $this->line('  <fg=yellow>*</> <fg=white>If you like Laravilt, please give us a star on GitHub!</>');
        $this->line('    <fg=cyan>https://github.com/laravilt/laravilt</>');
        $this->newLine();

        if (confirm('Would you like to open the GitHub repository now?', false)) {
            $this->openUrl('https://github.com/laravilt/laravilt');
        }

        $this->newLine();
        $this->line('  <fg=blue>Documentation:</> <fg=cyan>https://laravilt.com</>');
        $this->line('  <fg=blue>Report issues:</> <fg=cyan>https://github.com/laravilt/laravilt/issues</>');
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
