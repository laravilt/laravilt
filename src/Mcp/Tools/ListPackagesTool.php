<?php

namespace Laravilt\Laravilt\Mcp\Tools;

use Illuminate\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\File;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class ListPackagesTool extends Tool
{
    /**
     * The tool's description.
     */
    protected string $description = 'List all installed Laravilt packages with their versions and descriptions';

    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $packagesPath = base_path('packages/laravilt');

        if (! File::isDirectory($packagesPath)) {
            return Response::text('No Laravilt packages directory found.');
        }

        $packages = [];
        $directories = File::directories($packagesPath);

        foreach ($directories as $dir) {
            $composerJsonPath = $dir.'/composer.json';
            if (File::exists($composerJsonPath)) {
                $composerData = json_decode(File::get($composerJsonPath), true);
                $packages[] = [
                    'name' => basename($dir),
                    'package' => $composerData['name'] ?? 'N/A',
                    'description' => $composerData['description'] ?? 'N/A',
                    'version' => $composerData['version'] ?? 'N/A',
                    'path' => $dir,
                ];
            }
        }

        if (empty($packages)) {
            return Response::text('No Laravilt packages found.');
        }

        $output = "# Laravilt Packages\n\n";
        $output .= 'Found '.count($packages)." package(s):\n\n";

        foreach ($packages as $package) {
            $output .= "## {$package['name']}\n";
            $output .= "- **Package:** {$package['package']}\n";
            $output .= "- **Version:** {$package['version']}\n";
            $output .= "- **Description:** {$package['description']}\n";
            $output .= "- **Path:** {$package['path']}\n\n";
        }

        return Response::text($output);
    }

    /**
     * Get the tool's input schema.
     *
     * @return array<string, \Illuminate\JsonSchema\JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [];
    }
}
