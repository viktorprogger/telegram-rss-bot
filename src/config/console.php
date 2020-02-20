<?php
declare(strict_types=1);

use rssBot\services\formatters\FormatterInterface;
use rssBot\services\formatters\TelegramDefaultFormatter;
use rssBot\services\parsers\RssParser;
use rssBot\services\parsers\ParserInterface;
use rssBot\services\senders\SenderInterface;
use rssBot\services\senders\TelegramSender;
use Spiral\Database\DatabaseInterface;
use Spiral\Database\DatabaseManager;
use yii\db\Connection;
use yii\log\FileTarget;

$params = require __DIR__ . '/params.php';

$config = [
    'id'                  => 'telegram-rss-bot',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'controllerNamespace' => 'rssBot\\commands',
    'aliases'             => [
        '@tests' => '@app/tests',
    ],
    'components'          => [
        'log' => [
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'  => [
            'class'    => Connection::class,
            'dsn'      => 'pgsql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME'),
            'username' => getenv('DB_LOGIN'),
            'password' => getenv('DB_PASSWORD'),
            'charset'  => 'utf8',
        ],
    ],
    'params'              => $params,
    'container'           => [
        'singletons' => [
            FormatterInterface::class => ['class' => TelegramDefaultFormatter::class],
            ParserInterface::class    => ['class' => RssParser::class],
            SenderInterface::class    => ['class' => TelegramSender::class],
        ],
    ],
];
