<?php

declare(strict_types=1);

namespace rssBot\queue;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Yiisoft\EventDispatcher\Provider\Provider;
use Yiisoft\Yii\Queue\Cli\LoopInterface;
use Yiisoft\Yii\Queue\Driver\DriverInterface;
use Yiisoft\Yii\Queue\Queue;
use Yiisoft\Yii\Queue\Worker\WorkerInterface;

class SendQueue extends Queue
{
    public function __construct(
        DriverInterface $driver,
        EventDispatcherInterface $dispatcher,
        Provider $provider,
        WorkerInterface $worker,
        LoopInterface $loop,
        LoggerInterface $logger
    ) {
        parent::__construct($driver, $dispatcher, $provider, $worker, $loop, $logger);
    }
}
