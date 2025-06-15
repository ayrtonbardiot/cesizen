<?php

return [

    'install-button' => true,

    'manifest' => [
        'name' => 'CESIZen',
        'short_name' => 'CZen',
        'start_url' => '/',
        'background_color' => '#fceee2',
        'theme_color' => '#e1705b',
        'display' => 'fullscreen',
        'orientation' => 'portrait',
        'status_bar' => 'black-translucent',
        'description' => 'Application bien-être de l\'équipe CESIZen — calme, respiration, diagnostic, émotions.',
        'icons' => [
            [
                'src' => 'assets/img/icon-72x72.png',
                'sizes' => '72x72',
                'type' => 'image/png',
            ],
            [
                'src' => 'assets/img/icon-192x192.png',
                'sizes' => '192x192',
                'type' => 'image/png',
            ],
            [
                'src' => 'assets/img/icon-512x512.png',
                'sizes' => '512x512',
                'type' => 'image/png',
            ],
        ],
    ],

    'debug' => env('APP_DEBUG', false),

    'livewire-app' => false,
];