<?php

namespace Laravilt\Laravilt\Mcp;

use Laravel\Mcp\Server;
use Laravilt\Laravilt\Mcp\Tools\InstallLaraviltTool;
use Laravilt\Laravilt\Mcp\Tools\ListPackagesTool;
use Laravilt\Laravilt\Mcp\Tools\MakeUserTool;
use Laravilt\Laravilt\Mcp\Tools\PackageInfoTool;
use Laravilt\Laravilt\Mcp\Tools\SearchDocsTool;

class LaraviltServer extends Server
{
    /**
     * The MCP server's name.
     */
    protected string $name = 'Laravilt';

    /**
     * The MCP server's version.
     */
    protected string $version = '1.0.0';

    /**
     * The MCP server's instructions for the LLM.
     */
    protected string $instructions = <<<'MARKDOWN'
        This server provides management capabilities for Laravilt admin panel.

        Laravilt is a modern Laravel Admin Panel built with Vue 3, Inertia.js, and AI capabilities.

        You can:
        - Install and configure Laravilt
        - Create admin users
        - List all installed Laravilt packages
        - Get information about specific packages
        - Search documentation across all packages

        Key features:
        - Panel management (panels, pages, resources, clusters)
        - Form builder with 30+ field types
        - Table builder with filters, sorting, bulk actions
        - AI integration (OpenAI, Anthropic, Gemini)
        - Authentication (passwords, social login, passkeys)
        - Notifications and widgets

        All Laravilt packages are located in the packages/laravilt directory.
    MARKDOWN;

    /**
     * The tools registered with this MCP server.
     *
     * @var array<int, class-string<\Laravel\Mcp\Server\Tool>>
     */
    protected array $tools = [
        ListPackagesTool::class,
        PackageInfoTool::class,
        InstallLaraviltTool::class,
        MakeUserTool::class,
        SearchDocsTool::class,
    ];
}
