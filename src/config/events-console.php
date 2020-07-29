<?php

use Yiisoft\Arrays\Modifier\ReplaceValue;
use Yiisoft\Yii\Queue\Event\JobFailure;

return [
    JobFailure::class => new ReplaceValue(
        [
            ['queueFetch', 'jobRetry'],
            ['queueSend', 'jobRetry'],
        ]
    ),
    \rssBot\queue\events\FetchEvent::class => [
        [\rssBot\queue\handlers\SourceHandler::class, 'fetch']
    ],
];
