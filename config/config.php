<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'authorization_header' => env('API_KEYS_AUTHORIZATION_HEADER', 'X-Authorization'),
    'logs' => [
        'admin_events' => env('API_KEYS_LOG_ADMIN_EVENTS', true),
        'access_events' => env('API_KEYS_LOG_ACCESS_EVENTS', true),
    ],
    'key_prefix' => env('API_KEYS_KEY_PREFIX', ''),
    'tables' => [
        'keys' => env('API_KEYS_TABLE_NAME', 'api_keys'),
        'events' => env('API_KEYS_EVENTS_TABLE_NAME', 'api_key_events'),
    ],
];