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
];
