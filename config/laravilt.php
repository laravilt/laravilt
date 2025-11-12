<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Panel Configuration
    |--------------------------------------------------------------------------
    |
    | Configure your Laravilt panel settings including path, domain, and
    | navigation. Multiple panels can be configured for different admin areas.
    |
    */

    'panel' => [
        'id' => env('LARAVILT_PANEL_ID', 'admin'),
        'path' => env('LARAVILT_PANEL_PATH', '/admin'),
        'domain' => env('LARAVILT_PANEL_DOMAIN', null),
    ],

    /*
    |--------------------------------------------------------------------------
    | Resources
    |--------------------------------------------------------------------------
    |
    | Register your resource classes here. Resources are automatically
    | discovered from the app/Laravilt/Resources directory.
    |
    */

    'resources' => [
        // 'discover' => [
        //     'App\\Laravilt\\Resources',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pages
    |--------------------------------------------------------------------------
    |
    | Register your custom page classes here. Pages are automatically
    | discovered from the app/Laravilt/Pages directory.
    |
    */

    'pages' => [
        // 'discover' => [
        //     'App\\Laravilt\\Pages',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Multi-Platform Generation
    |--------------------------------------------------------------------------
    |
    | Enable or disable automatic generation of Vue components, Flutter
    | modules, and REST API endpoints from your Resources.
    |
    */

    'generate' => [
        'vue' => env('LARAVILT_GENERATE_VUE', true),
        'flutter' => env('LARAVILT_GENERATE_FLUTTER', true),
        'api' => env('LARAVILT_GENERATE_API', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | AI & MCP Integration
    |--------------------------------------------------------------------------
    |
    | Enable AI agent and MCP server generation for your Resources.
    |
    */

    'ai' => [
        'enabled' => env('LARAVILT_AI_ENABLED', false),
    ],

    'mcp' => [
        'enabled' => env('LARAVILT_MCP_ENABLED', false),
    ],
];
