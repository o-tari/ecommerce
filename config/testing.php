<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Testing Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options specifically for testing.
    | These settings will be used when APP_ENV=testing
    |
    */

    'database' => [
        'connection' => 'sqlite',
        'database' => ':memory:',
    ],

    'cache' => [
        'driver' => 'array',
        'store' => 'array',
    ],

    'session' => [
        'driver' => 'array',
        'lifetime' => 120,
    ],

    'mail' => [
        'driver' => 'array',
    ],

    'queue' => [
        'connection' => 'sync',
    ],

    'broadcasting' => [
        'driver' => 'log',
    ],

    'logging' => [
        'channel' => 'single',
        'level' => 'debug',
    ],

    'features' => [
        'telescope' => false,
        'pulse' => false,
    ],

    'filament' => [
        'middleware' => [
            'web' => [
                \Illuminate\Cookie\Middleware\EncryptCookies::class,
                \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
            ],
        ],
    ],

    'security' => [
        'bcrypt_rounds' => 4,
    ],
];
