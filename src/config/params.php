<?php

declare(strict_types=1);

use rssBot\commands\Parse;
use rssBot\models\action\action\ActionPayload;
use rssBot\models\action\queue\MessageHandler;
use rssBot\models\source\SourceType;

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
    'yiisoft/yii-queue' => [
        'handlers' => [
            ActionPayload::NAME => [MessageHandler::class, 'handle'],
        ],
    ],
];
