<?php

declare(strict_types=1);

use rssBot\commands\Parse;
use rssBot\models\sender\converter\RssMarkdownConverter;
use rssBot\models\sender\SenderType;
use rssBot\models\source\SourceType;
use Yiisoft\Factory\Definitions\Reference;
use Yiisoft\Yii\Queue\Command\ListenCommand;
use Yiisoft\Yii\Queue\Command\RunCommand;

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
        ],
    ],
    'senders' => [
        [
            'type' => SenderType::telegram(),
            'token' => getenv('BOT_TOKEN'), // TODO
            'sources' => [
                [
                    'code' => 'storm',
                    'converter' => RssMarkdownConverter::class,
                ],
                // В обоих фильтрах ниже - массив объектов \Yiisoft\Validator\Rule или просто callable
                // Список фильтров, применяемых к SourceItem до того, как произведется конвертация в Message
                'preFilters' => [],
                // Список фильтров, применяемых к Message (после конвертации из SourceItem)
                'postFilters' => [],
            ],
        ],
    ],
];
