<?php
declare(strict_types=1);

use yii\log\FileTarget;
use yii\db\Connection;
use yii\helpers\ArrayHelper;

$params = require __DIR__ . '/params.php';

$config = [
    'id' => 'telegram-rss-bot',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'rss-bot\commands',
    'aliases' => [
        '@tests' => '@app/tests',
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => [
            'class' => Connection::class,
            'dsn' => 'pgsql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME'),
            'username' => getenv('DB_LOGIN'),
            'password' => getenv('DB_PASSWORD'),
            'charset' => 'utf8',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return ArrayHelper::merge($config, require __DIR__ . '/common.php');
