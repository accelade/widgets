<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Routes Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the routes for the widgets demo and documentation pages.
    |
    */
    'routes' => [
        'enabled' => true,
        'prefix' => 'widgets',
        'middleware' => ['web'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Documentation Configuration
    |--------------------------------------------------------------------------
    |
    | Configure whether to register widgets documentation in Accelade docs.
    |
    */
    'docs' => [
        'enabled' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Grid Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the default grid settings for widget layouts.
    |
    */
    'grid' => [
        'columns' => 12,
        'gap' => 6,
    ],

    /*
    |--------------------------------------------------------------------------
    | Chart Configuration
    |--------------------------------------------------------------------------
    |
    | Default configuration for chart widgets.
    |
    */
    'charts' => [
        'default_height' => 300,
        'colors' => [
            'primary' => '#3b82f6',
            'success' => '#22c55e',
            'warning' => '#f59e0b',
            'danger' => '#ef4444',
            'info' => '#06b6d4',
            'gray' => '#6b7280',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Stats Configuration
    |--------------------------------------------------------------------------
    |
    | Default configuration for stats widgets.
    |
    */
    'stats' => [
        'default_columns' => 4,
        'icon_size' => 'md',
    ],

    /*
    |--------------------------------------------------------------------------
    | Table Configuration
    |--------------------------------------------------------------------------
    |
    | Default configuration for table widgets.
    |
    */
    'tables' => [
        'per_page' => 10,
        'striped' => false,
        'hoverable' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Polling Configuration
    |--------------------------------------------------------------------------
    |
    | Configure auto-refresh intervals for widgets.
    |
    */
    'polling' => [
        'enabled' => true,
        'default_interval' => null, // e.g., '10s', '30s', '1m'
    ],
];
