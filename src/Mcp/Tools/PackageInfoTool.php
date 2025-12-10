<?php

namespace Laravilt\Laravilt\Mcp\Tools;

use Illuminate\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\File;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class PackageInfoTool extends Tool
{
    /**
     * The tool's description.
     */
    protected string $description = 'Get detailed information about a specific Laravilt package';

    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $packageName = $request->get('package');
        $packagePath = base_path("packages/laravilt/{$packageName}");

        if (! File::isDirectory($packagePath)) {
            return Response::text("Package '{$packageName}' not found.");
        }

        $composerJsonPath = $packagePath.'/composer.json';
        if (! File::exists($composerJsonPath)) {
            return Response::text("Package '{$packageName}' has no composer.json.");
        }

        $composerData = json_decode(File::get($composerJsonPath), true);

        $output = "# {$packageName}\n\n";
        $output .= '**Package:** '.($composerData['name'] ?? 'N/A')."\n";
        $output .= '**Version:** '.($composerData['version'] ?? 'N/A')."\n";
        $output .= '**Description:** '.($composerData['description'] ?? 'N/A')."\n\n";

        // Dependencies
        if (isset($composerData['require']) && ! empty($composerData['require'])) {
            $output .= "## Dependencies\n\n";
            foreach ($composerData['require'] as $dep => $version) {
                $output .= "- {$dep}: {$version}\n";
            }
            $output .= "\n";
        }

        // Autoload namespaces
        if (isset($composerData['autoload']['psr-4'])) {
            $output .= "## Namespaces\n\n";
            foreach ($composerData['autoload']['psr-4'] as $namespace => $path) {
                $output .= "- {$namespace} => {$path}\n";
            }
            $output .= "\n";
        }

        // Directory structure
        $output .= "## Directory Structure\n\n";
        $output .= "```\n";
        $output .= $this->getDirectoryStructure($packagePath, '', 2);
        $output .= "```\n\n";

        // README if exists
        $readmePath = $packagePath.'/README.md';
        if (File::exists($readmePath)) {
            $readme = File::get($readmePath);
            // Get first 500 chars
            $output .= "## README Preview\n\n";
            $output .= substr($readme, 0, 500)."...\n";
        }

        return Response::text($output);
    }

    /**
     * Get directory structure.
     */
    protected function getDirectoryStructure(string $path, string $prefix = '', int $maxDepth = 2, int $currentDepth = 0): string
    {
        if ($currentDepth >= $maxDepth) {
            return '';
        }

        $output = '';
        $items = File::directories($path);

        foreach ($items as $item) {
            $name = basename($item);

            // Skip vendor and node_modules
            if (in_array($name, ['vendor', 'node_modules', '.git'])) {
                continue;
            }

            $output .= $prefix.$name."/\n";
            $output .= $this->getDirectoryStructure($item, $prefix.'  ', $maxDepth, $currentDepth + 1);
        }

        return $output;
    }

    /**
     * Get the tool's input schema.
     *
     * @return array<string, \Illuminate\JsonSchema\JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'package' => $schema->string('The package name (e.g., panel, forms, tables, auth, ai)')->required(),
        ];
    }
}
