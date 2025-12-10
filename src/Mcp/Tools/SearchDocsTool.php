<?php

namespace Laravilt\Laravilt\Mcp\Tools;

use Illuminate\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\File;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class SearchDocsTool extends Tool
{
    /**
     * The tool's description.
     */
    protected string $description = 'Search documentation across all Laravilt packages for a specific topic or keyword';

    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $query = strtolower($request->get('query'));
        $package = $request->get('package', 'all');

        $packagesPath = base_path('packages/laravilt');
        $results = [];

        if ($package === 'all') {
            $packages = File::directories($packagesPath);
        } else {
            $packagePath = $packagesPath.'/'.$package;
            if (! File::isDirectory($packagePath)) {
                return Response::text("Package '{$package}' not found.");
            }
            $packages = [$packagePath];
        }

        foreach ($packages as $packageDir) {
            $packageName = basename($packageDir);
            $docsPath = $packageDir.'/docs';

            if (! File::isDirectory($docsPath)) {
                continue;
            }

            $docFiles = File::allFiles($docsPath);

            foreach ($docFiles as $file) {
                if ($file->getExtension() !== 'md') {
                    continue;
                }

                $content = File::get($file->getPathname());
                $contentLower = strtolower($content);

                if (str_contains($contentLower, $query)) {
                    // Get context around the match
                    $pos = strpos($contentLower, $query);
                    $start = max(0, $pos - 100);
                    $context = substr($content, $start, 300);

                    $results[] = [
                        'package' => $packageName,
                        'file' => $file->getFilename(),
                        'path' => $file->getPathname(),
                        'context' => '...'.trim($context).'...',
                    ];
                }
            }
        }

        if (empty($results)) {
            return Response::text("No documentation found matching '{$query}'.");
        }

        $output = "# Search Results for '{$query}'\n\n";
        $output .= 'Found '.count($results)." match(es):\n\n";

        foreach ($results as $result) {
            $output .= "## {$result['package']}/{$result['file']}\n";
            $output .= "**Path:** {$result['path']}\n\n";
            $output .= "```\n{$result['context']}\n```\n\n";
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
        return [
            'query' => $schema->string('Search query (keyword or phrase)')->required(),
            'package' => $schema->string('Package to search in (or "all" for all packages)')
                ->enum(['all', 'panel', 'forms', 'tables', 'auth', 'ai', 'notifications', 'widgets', 'actions', 'schemas', 'infolists', 'support', 'query-builder', 'plugins'])
                ->default('all'),
        ];
    }
}
