<?php

return [
    /*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    |
    | The model that should be used for admin users. This model must extend
    | Illuminate\Foundation\Auth\User and implement the Authenticatable
    | contract.
    |
    */
    'user_model' => App\Models\User::class,

    /*
    |--------------------------------------------------------------------------
    | Admin Path
    |--------------------------------------------------------------------------
    |
    | The path prefix for all admin panel routes. By default, all routes will
    | be prefixed with '/admin'.
    |
    */
    'path' => 'admin',

    /*
    |--------------------------------------------------------------------------
    | Auth Guard
    |--------------------------------------------------------------------------
    |
    | The authentication guard to use for the admin panel. This should match
    | one of the guards defined in your auth.php configuration file.
    |
    */
    'guard' => 'web',

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | The middleware stack that will be applied to all admin panel routes.
    | You can add additional middleware here as needed.
    |
    */
    'middleware' => [
        'web',
        'auth',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Locale
    |--------------------------------------------------------------------------
    |
    | The default locale for the admin panel. This will be used when the user
    | has not set a preferred locale.
    |
    */
    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Available Locales
    |--------------------------------------------------------------------------
    |
    | The locales that are available in the admin panel. Users can switch
    | between these locales using the language switcher.
    |
    */
    'locales' => [
        'en'  => 'English',
        'ar'  => 'العربية',
        'ckb' => 'کوردی',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Timezone
    |--------------------------------------------------------------------------
    |
    | The default timezone for the admin panel. This will be used when the
    | user has not set a preferred timezone.
    |
    */
    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Brand Name
    |--------------------------------------------------------------------------
    |
    | The name that will be displayed in the admin panel sidebar and header.
    |
    */
    'brand' => env('APP_NAME', 'Laravilt'),

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | The path to the logo image that will be displayed in the admin panel.
    | Set to null to use the brand name instead.
    |
    */
    'logo' => null,

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | The path to the favicon image for the admin panel.
    |
    */
    'favicon' => null,

    /*
    |--------------------------------------------------------------------------
    | Dark Mode
    |--------------------------------------------------------------------------
    |
    | Whether dark mode is enabled by default in the admin panel.
    |
    */
    'dark_mode' => true,

    /*
    |--------------------------------------------------------------------------
    | Features
    |--------------------------------------------------------------------------
    |
    | Enable or disable various features of the admin panel.
    |
    */
    'features' => [
        'ai_assistant' => true,
        'global_search' => true,
        'notifications' => true,
        'user_menu' => true,
        'language_switcher' => true,
        'theme_switcher' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | AI Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the AI assistant feature.
    |
    */
    'ai' => [
        'enabled' => true,
        'provider' => env('LARAVILT_AI_PROVIDER', 'openai'),
        'model' => env('LARAVILT_AI_MODEL', 'gpt-4'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    |
    | Default pagination settings for tables in the admin panel.
    |
    */
    'pagination' => [
        'per_page' => 15,
        'per_page_options' => [10, 15, 25, 50, 100],
    ],
];
