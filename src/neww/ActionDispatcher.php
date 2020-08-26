<?php

declare(strict_types=1);

namespace rssBot\neww;

use rssBot\action\ActionInterface;
use rssBot\services\converter\ConverterLocatorInterface;
use Yiisoft\Yii\Queue\Queue;

class ActionDispatcher
{
    private ConverterLocatorInterface $converters;
    private ActionListenerProviderInterface $provider;
    private ActionFactoryInterface $factory;
    private Queue $queue;

    public function __construct(
        ConverterLocatorInterface $converters,
        ActionListenerProviderInterface $provider,
        ActionFactoryInterface $factory,
        Queue $queue
    )
    {
        $this->converters = $converters;
        $this->provider = $provider;
        $this->factory = $factory;
        $this->queue = $queue;
    }

    public function dispatch(ActionInterface $action, $result): void
    {
        $deferred = [];
        foreach ($this->provider->getListenersForAction($action) as $listener) {
            if ($result instanceof ResultCollection) {
                foreach ($result as $resultItem) {
                    if ($listener->suites($resultItem)) {
                        if ($listener->isSynchronous()) {
                            $listener->getAction($resultItem)->run();
                        } else {
                            $deferred[] = $listener;
                        }
                    }
                }
            } else {
                if ($listener->suites($result)) {
                    if ($listener->isSynchronous()) {
                        $listener->getAction($result)->run();
                    } else {
                        $deferred[] = $listener;
                    }
                }
            }
        }

        foreach ($deferred as $listener) {
            $this->queue->push($this->factory->createPayload($listener->getAction($result)));
        }
    }
}
