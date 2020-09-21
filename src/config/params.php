<?php

declare(strict_types=1);

use rssBot\commands\Parse;
use rssBot\models\sender\converter\RssMarkdownConverter;
use rssBot\models\sender\telegram\Sender as TelegramSender;
use rssBot\models\source\SourceType;
use rssBot\neww\ActionPayload;
use rssBot\neww\MessageHandler;

return [
    'yiisoft/yii-console' => [
        'commands' => [
            'parse' => Parse::class,
        ],
    ],
    'sources' => [
        'storm' => [
            'type' => SourceType::rss(),
            'title' => 'JetBrains PhpStorm',
            'code' => 'storm',
            'url' => 'https://blog.jetbrains.com/phpstorm/feed/',
            'senders' => [

            ]
        ],
    ],
    'senders' => [
        'storm' => [
            TelegramSender::class,
        ],
    ],
    'converters' => [
        TelegramSender::class => [
            'storm' => RssMarkdownConverter::class,
        ]
    ],
    'yiisoft/yii-queue' => [
        'handlers' => [
            ActionPayload::NAME => [MessageHandler::class, 'handle'],
        ],
    ],
];
