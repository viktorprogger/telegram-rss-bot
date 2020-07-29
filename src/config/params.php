<?php

declare(strict_types=1);

use rssBot\commands\Parse;
use rssBot\models\sender\converter\RssMarkdownConverter;
use rssBot\models\sender\SenderType;
use rssBot\models\sender\telegram\Sender as TelegramSender;
use rssBot\models\source\SourceType;
use rssBot\queue\handlers\MessageHandler;
use rssBot\queue\handlers\SourceHandler;
use rssBot\queue\jobs\SendItemJob;
use rssBot\queue\jobs\SourceFetchJob;

return [
    'yiisoft/yii-console' => [
        'commands' => [
            'parse' => Parse::class,
            'queue/fetch/listen' => 'queueFetchListenCommand',
            'queue/fetch/run' => 'queueFetchRunCommand',
            'queue/send/listen' => 'queueSendListenCommand',
            'queue/send/run' => 'queueSendRunCommand',
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
            SourceFetchJob::NAME => [SourceHandler::class, 'handle'],
            SendItemJob::NAME => [MessageHandler::class, 'handle'],
        ],
    ],
];
