<?php

namespace Laravilt\Laravilt\Support;

use Illuminate\Filesystem\Filesystem;
use InvalidArgumentException;

/**
 * Publishes a frontend stub set described by a manifest file:
 *
 *   return [
 *       'publish' => ['<stub path relative to the manifest>' => '<target relative to the app>'],
 *       'delete' => ['<path relative to the app>'],
 *   ];
 *
 * Deletions run first, so a published stub can replace a deleted directory.
 */
class StubManifestPublisher
{
    public function __construct(protected Filesystem $files = new Filesystem) {}

    /**
     * @return array{published: list<string>, deleted: list<string>}
     */
    public function publish(string $manifestPath, string $basePath): array
    {
        if (! $this->files->exists($manifestPath)) {
            throw new InvalidArgumentException("Stub manifest [{$manifestPath}] does not exist.");
        }

        $manifest = require $manifestPath;

        if (! is_array($manifest)) {
            throw new InvalidArgumentException("Stub manifest [{$manifestPath}] must return an array.");
        }

        $stubRoot = dirname($manifestPath);
        $basePath = rtrim($basePath, '/\\');
        $deleted = [];
        $published = [];

        foreach ($manifest['delete'] ?? [] as $relative) {
            $path = $basePath.'/'.ltrim($relative, '/\\');

            if ($this->files->isDirectory($path)) {
                $this->files->deleteDirectory($path);
                $deleted[] = $relative;
            } elseif ($this->files->exists($path)) {
                $this->files->delete($path);
                $deleted[] = $relative;
            }
        }

        foreach ($manifest['publish'] ?? [] as $stub => $target) {
            $from = $stubRoot.'/'.ltrim($stub, '/\\');
            $to = $basePath.'/'.ltrim($target, '/\\');

            if ($this->files->isDirectory($from)) {
                $this->files->copyDirectory($from, $to);
            } elseif ($this->files->exists($from)) {
                $this->files->ensureDirectoryExists(dirname($to));
                $this->files->copy($from, $to);
            } else {
                throw new InvalidArgumentException("Stub [{$stub}] listed in the manifest does not exist.");
            }

            $published[] = $target;
        }

        return ['published' => $published, 'deleted' => $deleted];
    }
}
