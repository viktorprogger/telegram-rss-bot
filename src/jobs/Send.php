<?php

declare(strict_types=1);

namespace rssBot\jobs;

use yii\queue\JobInterface;
use yii\queue\Queue;

class Send implements JobInterface
{
    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function execute($queue)
    {
        // TODO: Implement execute() method.
    }
}
