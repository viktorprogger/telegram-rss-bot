<?php

declare(strict_types=1);

namespace Resender\Infrastructure\Queue;

use FeedIo\Reader\ReadErrorException;
use Yiisoft\Yii\Queue\Event\JobFailure;

final class FailureEventHandler
{
    public function handle(JobFailure $event): void
    {
        if ($event->getException() instanceof ReadErrorException) {
            $event->preventThrowing();
        }
    }
}
