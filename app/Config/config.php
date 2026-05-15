<?php

declare(strict_types=1);

return [
    'app_name' => 'Corporate Law Knowledge ERP',
    'base_url' => getenv('APP_URL') ?: 'http://localhost/CorporateLawBot',
    'db' => [
        'host' => getenv('DB_HOST') ?: '127.0.0.1',
        'port' => getenv('DB_PORT') ?: '3306',
        'database' => getenv('DB_NAME') ?: 'corporate_law_erp',
        'username' => getenv('DB_USER') ?: 'root',
        'password' => getenv('DB_PASS') ?: '',
        'charset' => 'utf8mb4',
    ],
    'storage' => [
        'uploads' => dirname(__DIR__, 2) . '/storage/uploads',
        'exports' => dirname(__DIR__, 2) . '/storage/exports',
    ],
    'auth' => [
        'default_redirect' => '/dashboard',
    ],
];
