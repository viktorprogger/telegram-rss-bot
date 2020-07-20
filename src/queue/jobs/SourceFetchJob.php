<?php

declare(strict_types=1);

namespace rssBot\queue\jobs;

use Psr\EventDispatcher\EventDispatcherInterface;
use rssBot\models\source\SourceInterface;
use rssBot\queue\events\FetchEvent;
use Yiisoft\Yii\Queue\Job\JobInterface;

final class SourceFetchJob implements JobInterface
{
    private SourceInterface $source;
    private EventDispatcherInterface $dispatcher;

    public function __construct(SourceInterface $source, EventDispatcherInterface $dispatcher)
    {
        $this->source = $source;
        $this->dispatcher = $dispatcher;
    }

    public function execute(): void
    {
        $event = new FetchEvent($this->source);
        $this->dispatcher->dispatch($event);
    }
}
