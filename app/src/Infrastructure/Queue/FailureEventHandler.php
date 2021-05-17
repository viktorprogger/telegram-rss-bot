<?php

declare(strict_types=1);

namespace Resender\Infrastructure\Queue;

use Yiisoft\Yii\Queue\Event\JobFailure;

final class FailureEventHandler
{
    public function handle(JobFailure $event): void
    {
        $event->preventThrowing();
    }
}
