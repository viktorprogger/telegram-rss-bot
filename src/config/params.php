<?php

declare(strict_types=1);

use rssBot\commands\Parse;
use Spiral\Database\Driver\Postgres\PostgresDriver;

return [
    'console' => [
        'commands' => [
            'parse' => Parse::class,
        ],
    ],
    'cycle.dbal' => [
        'default' => 'default',
        'databases' => [
            'default' => [
                'connection' => 'default',
                'prefix' => 'cycle_'
            ],
            'old' => [
                'connection' => 'default',
            ],
        ],
        'connections' => [
            'default' => [
                'driver' => PostgresDriver::class,
                'options' => [
                    'connection' => 'pgsql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME'),
                    'username' => getenv('DB_LOGIN'),
                    'password' => getenv('DB_PASSWORD'),
                    'timezone' => 'Europe/Moscow',
                ],
            ],
        ],
    ],
];
