<?php

declare(strict_types=1);

use Resender\SubDomain\Rss\Infrastructure\QueueHandler\SourceHandler;
use Yiisoft\Yii\Queue\Command\ListenCommand;
use Yiisoft\Yii\Queue\Command\RunCommand;

return [
    'yiisoft/yii-console' => [
        'commands' => [
            'queue/run' => RunCommand::class,
            'queue/listen' => ListenCommand::class,
        ],
    ],
    'yiisoft/yii-queue' => [
        'handlers' => [
            SourceHandler::MESSAGE_NAME => [SourceHandler::class, 'handle'],
        ],
        'channel-definitions' => [],
    ],
];
