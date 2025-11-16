# Sprint 1: Foundation (Week 1)

## Goals

- Set up monorepo structure
- Create package generator command
- Build `laravilt/support` package (foundation)
- Establish testing infrastructure
- Document everything

## Prerequisites

- Laravel 12 project already set up (✅ Done - `/Users/fadymondy/Sites/laravilt`)
- Node.js & npm installed
- Flutter SDK installed
- Composer installed

## Tasks

### Task 1.1: Create Package Generator Command

**Objective**: Create an Artisan command that scaffolds a complete package with all necessary files.

**Command**: `php artisan laravilt:make-package {name}`

**Files to Create**:

1. `app/Console/Commands/MakePackageCommand.php`

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakePackageCommand extends Command
{
    protected $signature = 'laravilt:make-package {name : The package name}';
    protected $description = 'Create a new Laravilt package with complete structure';

    public function handle(): int
    {
        $name = $this->argument('name');
        $packageName = Str::kebab($name);
        $studlyName = Str::studly($name);

        $this->info("Creating package: laravilt/{$packageName}");

        // Create directory structure
        $this->createDirectoryStructure($packageName);

        // Create files
        $this->createComposerJson($packageName, $studlyName);
        $this->createPackageJson($packageName);
        $this->createPubspecYaml($packageName);
        $this->createServiceProvider($packageName, $studlyName);
        $this->createGitHubWorkflows($packageName);
        $this->createStandardFiles($packageName, $studlyName);
        $this->createTestFiles($packageName, $studlyName);
        $this->createConfigFiles($packageName);

        // Update root composer.json
        $this->updateRootComposer($packageName);

        $this->info("✅ Package created successfully!");
        $this->info("📁 Location: packages/laravilt/{$packageName}");
        $this->info("📝 Next steps:");
        $this->line("   1. cd packages/laravilt/{$packageName}");
        $this->line("   2. composer install");
        $this->line("   3. Start coding in src/");

        return self::SUCCESS;
    }

    protected function createDirectoryStructure(string $packageName): void
    {
        $base = base_path("packages/laravilt/{$packageName}");

        $directories = [
            '',
            '.github/workflows',
            '.github/ISSUE_TEMPLATE',
            'src',
            'src/Components',
            'src/Concerns',
            'src/Contracts',
            'src/Commands',
            'resources/js/components',
            'resources/js/composables',
            'resources/js/types',
            'resources/flutter/lib',
            'tests/php/Feature',
            'tests/php/Unit',
            'tests/vue',
            'tests/flutter',
            'docs/examples',
        ];

        foreach ($directories as $dir) {
            File::makeDirectory("{$base}/{$dir}", 0755, true, true);
        }
    }

    protected function createComposerJson(string $packageName, string $studlyName): void
    {
        $content = [
            'name' => "laravilt/{$packageName}",
            'description' => "Laravilt {$studlyName} Package",
            'keywords' => ['laravel', 'laravilt', 'vue', 'inertia', 'flutter', 'admin'],
            'homepage' => "https://github.com/laravilt/{$packageName}",
            'license' => 'MIT',
            'authors' => [
                [
                    'name' => 'Fady Mondy',
                    'email' => 'fadymondy@example.com',
                    'role' => 'Developer',
                ],
            ],
            'require' => [
                'php' => '^8.2',
                'illuminate/contracts' => '^11.0|^12.0',
            ],
            'require-dev' => [
                'laravel/pint' => '^1.24',
                'larastan/larastan' => '^3.0',
                'nunomaduro/collision' => '^8.0',
                'orchestra/testbench' => '^9.0',
                'pestphp/pest' => '^4.0',
                'pestphp/pest-plugin-laravel' => '^4.0',
                'phpstan/phpstan' => '^2.0',
            ],
            'autoload' => [
                'psr-4' => [
                    "Laravilt\\{$studlyName}\\" => 'src/',
                ],
            ],
            'autoload-dev' => [
                'psr-4' => [
                    "Laravilt\\{$studlyName}\\Tests\\" => 'tests/',
                ],
            ],
            'scripts' => [
                'test' => 'vendor/bin/pest',
                'test:coverage' => 'vendor/bin/pest --coverage',
                'test:types' => 'vendor/bin/phpstan analyse --memory-limit=2G',
                'test:style' => 'vendor/bin/pint --test',
                'format' => 'vendor/bin/pint',
            ],
            'config' => [
                'sort-packages' => true,
                'allow-plugins' => [
                    'pestphp/pest-plugin' => true,
                ],
            ],
            'extra' => [
                'laravel' => [
                    'providers' => [
                        "Laravilt\\{$studlyName}\\{$studlyName}ServiceProvider",
                    ],
                ],
            ],
            'minimum-stability' => 'dev',
            'prefer-stable' => true,
        ];

        $path = base_path("packages/laravilt/{$packageName}/composer.json");
        File::put($path, json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    protected function createServiceProvider(string $packageName, string $studlyName): void
    {
        $content = <<<PHP
<?php

namespace Laravilt\\{$studlyName};

use Illuminate\\Support\\ServiceProvider;

class {$studlyName}ServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

PHP;

        $path = base_path("packages/laravilt/{$packageName}/src/{$studlyName}ServiceProvider.php");
        File::put($path, $content);
    }

    protected function createStandardFiles(string $packageName, string $studlyName): void
    {
        // README.md, LICENSE.md, CHANGELOG.md, etc.
        // Implementation details...
    }

    protected function updateRootComposer(string $packageName): void
    {
        $composerPath = base_path('composer.json');
        $composer = json_decode(File::get($composerPath), true);

        // Add path repository
        $composer['repositories'][] = [
            'type' => 'path',
            'url' => "packages/laravilt/{$packageName}",
        ];

        File::put($composerPath, json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    // Additional helper methods...
}
```

**Test Command**:
```bash
php artisan laravilt:make-package TestPackage
```

**Acceptance Criteria**:
- [ ] Command creates complete package structure
- [ ] All directories created
- [ ] composer.json generated with correct autoloading
- [ ] ServiceProvider created
- [ ] Root composer.json updated
- [ ] Can run `composer install` in package

---

### Task 1.2: Create `laravilt/support` Package

**Objective**: Build the foundation package with contracts, traits, and utilities.

**Command**:
```bash
php artisan laravilt:make-package Support
cd packages/laravilt/support
```

**Files to Create**:

#### 1. Contracts

**`src/Contracts/Buildable.php`**:
```php
<?php

namespace Laravilt\Support\Contracts;

interface Buildable
{
    /**
     * Create a new instance with fluent interface
     */
    public static function make(string $name): static;
}
```

**`src/Contracts/InertiaSerializable.php`**:
```php
<?php

namespace Laravilt\Support\Contracts;

interface InertiaSerializable
{
    /**
     * Convert to Inertia props for Vue rendering
     */
    public function toInertiaProps(): array;
}
```

**`src/Contracts/FlutterSerializable.php`**:
```php
<?php

namespace Laravilt\Support\Contracts;

interface FlutterSerializable
{
    /**
     * Convert to Flutter-compatible JSON
     */
    public function toFlutterProps(): array;
}
```

#### 2. Concerns (Traits)

**`src/Concerns/HasState.php`**:
```php
<?php

namespace Laravilt\Support\Concerns;

trait HasState
{
    protected mixed $state = null;
    protected mixed $default = null;

    public function default(mixed $default): static
    {
        $this->default = $default;
        return $this;
    }

    public function state(mixed $state): static
    {
        $this->state = $state;
        return $this;
    }

    public function getState(): mixed
    {
        return $this->state ?? $this->default;
    }
}
```

**`src/Concerns/HasValidation.php`**:
```php
<?php

namespace Laravilt\Support\Concerns;

trait HasValidation
{
    protected array $rules = [];
    protected array $validationMessages = [];

    public function rules(array $rules): static
    {
        $this->rules = array_merge($this->rules, $rules);
        return $this;
    }

    public function required(bool $required = true): static
    {
        if ($required) {
            $this->rules[] = 'required';
        }

        return $this;
    }

    public function getRules(): array
    {
        return $this->rules;
    }

    public function validationMessages(array $messages): static
    {
        $this->validationMessages = array_merge($this->validationMessages, $messages);
        return $this;
    }

    public function getValidationMessages(): array
    {
        return $this->validationMessages;
    }
}
```

#### 3. Tests

**`tests/php/Unit/HasStateTest.php`**:
```php
<?php

use Laravilt\Support\Concerns\HasState;

it('can set and get default value', function () {
    $component = new class {
        use HasState;
    };

    $component->default('test');

    expect($component->getState())->toBe('test');
});

it('state overrides default', function () {
    $component = new class {
        use HasState;
    };

    $component->default('default');
    $component->state('custom');

    expect($component->getState())->toBe('custom');
});
```

**`tests/php/Unit/HasValidationTest.php`**:
```php
<?php

use Laravilt\Support\Concerns\HasValidation;

it('can add validation rules', function () {
    $component = new class {
        use HasValidation;
    };

    $component->rules(['email', 'max:255']);

    expect($component->getRules())->toBe(['email', 'max:255']);
});

it('required adds required rule', function () {
    $component = new class {
        use HasValidation;
    };

    $component->required();

    expect($component->getRules())->toContain('required');
});
```

**Acceptance Criteria**:
- [ ] All contracts created
- [ ] All traits created
- [ ] Unit tests written and passing
- [ ] PHPStan level 8 passing
- [ ] Pint formatting passing
- [ ] Documentation complete

---

### Task 1.3: Testing Infrastructure

**Objective**: Set up testing for PHP, Vue, and Flutter across all packages.

#### Root-Level Test Scripts

**Update `composer.json`**:
```json
{
    "scripts": {
        "packages:test": "for package in packages/laravilt/*; do echo \"Testing $package...\" && cd $package && composer test && cd -; done",
        "packages:test:php": "for package in packages/laravilt/*; do cd $package && composer test && cd -; done",
        "packages:test:types": "for package in packages/laravilt/*; do cd $package && composer test:types && cd -; done",
        "packages:test:style": "for package in packages/laravilt/*; do cd $package && composer test:style && cd -; done",
        "packages:lint": "for package in packages/laravilt/*; do cd $package && composer format && cd -; done",
        "packages:test-all": [
            "@packages:lint",
            "@packages:test:types",
            "@packages:test"
        ]
    }
}
```

#### GitHub Actions Workflow

**`.github/workflows/packages.yml`**:
```yaml
name: Package Tests

on:
  push:
    branches: [main, develop]
  pull_request:
    branches: [main, develop]

jobs:
  test-packages:
    runs-on: ubuntu-latest

    strategy:
      fail-fast: false
      matrix:
        package: [support]  # Add more as we create them

    name: Test ${{ matrix.package }}

    steps:
      - name: Checkout code
        uses: actions/checkout@v4

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: 8.3
          extensions: dom, curl, libxml, mbstring, zip, pcntl, pdo, sqlite, pdo_sqlite
          coverage: none

      - name: Install dependencies
        working-directory: packages/laravilt/${{ matrix.package }}
        run: composer install --prefer-dist --no-interaction

      - name: Run Pint
        working-directory: packages/laravilt/${{ matrix.package }}
        run: vendor/bin/pint --test

      - name: Run PHPStan
        working-directory: packages/laravilt/${{ matrix.package }}
        run: vendor/bin/phpstan analyse

      - name: Run Pest
        working-directory: packages/laravilt/${{ matrix.package }}
        run: vendor/bin/pest
```

**Acceptance Criteria**:
- [ ] Root-level test commands work
- [ ] Can test all packages with one command
- [ ] GitHub Actions workflow created
- [ ] CI/CD passes for support package

---

### Task 1.4: Documentation

**Objective**: Document the support package.

**`packages/laravilt/support/README.md`**:
```markdown
# Laravilt Support

Foundation utilities and contracts for Laravilt Framework.

## Installation

```bash
composer require laravilt/support
```

## Contracts

### Buildable
Interface for components with fluent builder pattern.

### InertiaSerializable
Interface for components that can be serialized to Inertia props.

### FlutterSerializable
Interface for components that can be serialized to Flutter JSON.

## Concerns (Traits)

### HasState
Provides state management for components.

### HasValidation
Provides validation rule management for components.

## Testing

```bash
composer test              # Run tests
composer test:coverage     # With coverage
composer test:types        # PHPStan analysis
composer test:style        # Code style check
composer format            # Auto-fix code style
```

## License

MIT
```

---

## Testing Sprint 1

### Run All Tests

```bash
# Test support package
cd packages/laravilt/support
composer test
composer test:types
composer test:style

# Test from root
composer packages:test-all
```

### Verify Output

All tests should pass:
- ✅ Pest tests passing
- ✅ PHPStan level 8 passing
- ✅ Pint formatting passing

---

## Deliverables

- [ ] Package generator command working
- [ ] `laravilt/support` package complete
- [ ] All contracts and traits tested
- [ ] Testing infrastructure in place
- [ ] Documentation complete
- [ ] CI/CD passing

---

## Next Sprint

**Sprint 2: Core Package**
- Build `laravilt/core` package
- Create Component base class
- Create ComponentRegistry
- Implement serialization methods

---

## Time Estimate

- Task 1.1 (Package Generator): 4-6 hours
- Task 1.2 (Support Package): 6-8 hours
- Task 1.3 (Testing Infrastructure): 2-3 hours
- Task 1.4 (Documentation): 2-3 hours

**Total**: ~20 hours (1 week part-time)
