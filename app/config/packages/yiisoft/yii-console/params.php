<?php

declare(strict_types=1);

use Resender\Infrastructure\Commands\SourcesCommand;
use Yiisoft\Yii\Console\Command\Serve;

return [
    'yiisoft/yii-console' => [
        'id' => 'yii-console',
        'name' => 'Yii Console',
        'autoExit' => false,
        'commands' => [
            'serve' => Serve::class,
            'sources' => SourcesCommand::class,
        ],
        'version' => '3.0',
    ],
];
