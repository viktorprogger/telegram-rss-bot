<?php

declare(strict_types=1);

// Do not edit. Content will be replaced.
return [
    'common' => [
        '/' => [
            'config/common.php',
        ],
        'yiisoft/cache' => [
            'common.php',
        ],
        'yiisoft/cache-file' => [
            'common.php',
        ],
        'yiisoft/log-target-file' => [
            'common.php',
        ],
        'yiisoft/router-fastroute' => [
            'common.php',
        ],
        'yiisoft/yii-cycle' => [
            'common.php',
        ],
        'yiisoft/yii-queue-amqp' => [
            'common.php',
        ],
        'yiisoft/router' => [
            'common.php',
        ],
        'yiisoft/validator' => [
            'common.php',
        ],
        'yiisoft/yii-event' => [
            'common.php',
        ],
        'yiisoft/aliases' => [
            'common.php',
        ],
        'yiisoft/yii-queue' => [
            'common.php',
        ],
    ],
    'console' => [
        '/' => [
            '$common',
            'config/console.php',
        ],
        'yiisoft/yii-cycle' => [
            'console.php',
        ],
        'yiisoft/yii-console' => [
            'console.php',
        ],
        'yiisoft/yii-event' => [
            'console.php',
        ],
    ],
    'events' => [
        'yiisoft/yii-event' => [
            'events.php',
        ],
    ],
    'events-console' => [
        'yiisoft/yii-cycle' => [
            'events-console.php',
        ],
        'yiisoft/yii-event' => [
            '$events',
            'events-console.php',
        ],
    ],
    'events-web' => [
        'yiisoft/log' => [
            'events-web.php',
        ],
        'yiisoft/yii-event' => [
            '$events',
            'events-web.php',
        ],
    ],
    'params' => [
        '/' => [
            '$params',
            'config/params.php',
        ],
        'yiisoft/cache-file' => [
            'params.php',
        ],
        'yiisoft/log-target-file' => [
            'params.php',
        ],
        'yiisoft/router-fastroute' => [
            'params.php',
        ],
        'yiisoft/yii-cycle' => [
            'params.php',
        ],
        'yiisoft/yii-console' => [
            'params.php',
        ],
        'yiisoft/aliases' => [
            'params.php',
        ],
        'yiisoft/yii-queue' => [
            'params.php',
        ],
    ],
    'providers-console' => [
        '/' => [
            'config/providers-console.php',
        ],
        'yiisoft/yii-console' => [
            'providers-console.php',
        ],
    ],
    'providers-web' => [
        '/' => [
            'config/providers-web.php',
        ],
        'yiisoft/yii-cycle' => [
            'providers-web.php',
        ],
    ],
    'web' => [
        '/' => [
            '$common',
            'config/web.php',
        ],
        'yiisoft/error-handler' => [
            'web.php',
        ],
        'yiisoft/router-fastroute' => [
            'web.php',
        ],
        'yiisoft/middleware-dispatcher' => [
            'web.php',
        ],
        'yiisoft/yii-event' => [
            'web.php',
        ],
    ],
];
