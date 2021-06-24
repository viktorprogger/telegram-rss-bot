<?php

declare(strict_types=1);

use Resender\Infrastructure\Queue\FailureEventHandler;
use Yiisoft\Yii\Queue\Event\JobFailure;

return [
    JobFailure::class => [[FailureEventHandler::class, 'handle']],
];
