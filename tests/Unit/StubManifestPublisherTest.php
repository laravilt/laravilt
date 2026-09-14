<?php

use Illuminate\Filesystem\Filesystem;
use Laravilt\Laravilt\Support\StubManifestPublisher;

beforeEach(function () {
    $this->files = new Filesystem;
    $this->root = sys_get_temp_dir().'/laravilt-manifest-'.uniqid();
    $this->stubs = $this->root.'/stubs';
    $this->appPath = $this->root.'/app';

    $this->files->ensureDirectoryExists($this->stubs.'/ui');
    $this->files->ensureDirectoryExists($this->appPath.'/resources/js/pages/settings');

    $this->files->put($this->stubs.'/app.tsx.stub', 'app entry');
    $this->files->put($this->stubs.'/ui/button.tsx', 'button');
    $this->files->put($this->appPath.'/resources/js/pages/dashboard.tsx', 'kit dashboard');
    $this->files->put($this->appPath.'/resources/js/pages/settings/profile.tsx', 'kit profile');

    $this->files->put($this->stubs.'/manifest.php', '<?php return '.var_export([
        'publish' => [
            'app.tsx.stub' => 'resources/js/app.tsx',
            'ui' => 'resources/js/components/ui',
        ],
        'delete' => [
            'resources/js/pages/dashboard.tsx',
            'resources/js/pages/settings',
            'resources/js/pages/does-not-exist.tsx',
        ],
    ], true).';');
});

afterEach(function () {
    $this->files->deleteDirectory($this->root);
});

it('publishes files and directories and removes starter-kit files', function () {
    $result = (new StubManifestPublisher)->publish($this->stubs.'/manifest.php', $this->appPath);

    expect($this->files->get($this->appPath.'/resources/js/app.tsx'))->toBe('app entry')
        ->and($this->files->get($this->appPath.'/resources/js/components/ui/button.tsx'))->toBe('button')
        ->and($this->files->exists($this->appPath.'/resources/js/pages/dashboard.tsx'))->toBeFalse()
        ->and($this->files->isDirectory($this->appPath.'/resources/js/pages/settings'))->toBeFalse()
        ->and($result['published'])->toBe(['resources/js/app.tsx', 'resources/js/components/ui'])
        ->and($result['deleted'])->toBe(['resources/js/pages/dashboard.tsx', 'resources/js/pages/settings']);
});

it('fails when the manifest is missing', function () {
    (new StubManifestPublisher)->publish($this->stubs.'/missing.php', $this->appPath);
})->throws(InvalidArgumentException::class);

it('fails when a listed stub is missing', function () {
    $this->files->put($this->stubs.'/manifest.php', "<?php return ['publish' => ['nope.stub' => 'resources/js/nope.ts']];");

    (new StubManifestPublisher)->publish($this->stubs.'/manifest.php', $this->appPath);
})->throws(InvalidArgumentException::class);
