<?php

use Illuminate\Support\Str;

return [
    'driver' => env('ADMIN_SESSION_DRIVER', 'database'),
    'lifetime' => (int) env('ADMIN_SESSION_LIFETIME', 120),
    'expire_on_close' => env('ADMIN_SESSION_EXPIRE_ON_CLOSE', false),
    'encrypt' => env('ADMIN_SESSION_ENCRYPT', false),
    'files' => storage_path('framework/sessions'),
    'connection' => env('ADMIN_SESSION_CONNECTION'),
    'table' => env('ADMIN_SESSION_TABLE', 'admin_sessions'),
    'store' => env('ADMIN_SESSION_STORE'),
    'lottery' => [2, 100],
    'cookie' => env('ADMIN_SESSION_COOKIE', Str::slug(env('APP_NAME', 'laravel'), '_').'_admin_session'),
    'path' => env('ADMIN_SESSION_PATH', '/'),
    'domain' => env('ADMIN_SESSION_DOMAIN'),
    'secure' => env('ADMIN_SESSION_SECURE_COOKIE'),
    'http_only' => env('ADMIN_SESSION_HTTP_ONLY', true),
    'same_site' => env('ADMIN_SESSION_SAME_SITE', 'lax'),
    'partitioned' => env('ADMIN_SESSION_PARTITIONED_COOKIE', false),
];
