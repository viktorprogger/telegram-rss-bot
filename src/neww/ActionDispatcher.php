<?php

declare(strict_types=1);

namespace rssBot\neww;

use rssBot\action\ActionInterface;
use rssBot\services\converter\ConverterLocatorInterface;
use Yiisoft\Yii\Queue\Queue;

class ActionDispatcher implements ActionDispatcherInterface
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
        /** @var ListenerInterface[] $deferred */
        $deferred = [];
        foreach ($this->provider->getListenersForAction($action) as $listener) {
            if ($result instanceof ResultCollectionInterface) {
                $deferred = array_merge($deferred, $this->dispatchCollection($listener, $result));
            } else {
                $deferred = array_merge($deferred, $this->dispatchWithResult($listener, $result));
            }
        }

        foreach ($deferred as $listener) {
            $this->queue->push(
                $this->factory->createPayload(
                    $this->factory->createAction(
                        $listener->getActionDefinition(),
                        $result
                    )
                )
            );
        }
    }

    /**
     * @param ListenerInterface $listener
     * @param ResultCollectionInterface $result
     *
     * @return ListenerInterface[]
     */
    protected function dispatchCollection(ListenerInterface $listener, ResultCollectionInterface $result): array
    {
        $deferred = [];

        foreach ($result as $resultItem) {
            if ($resultItem instanceof ResultCollectionInterface) {
                $deferred = array_merge($deferred, $this->dispatchCollection($listener, $result));
            } else {
                $deferred = array_merge($deferred, $this->dispatchWithResult($listener, $result));
            }
        }

        return $deferred;
    }

    /**
     * @param ListenerInterface $listener
     * @param $result
     *
     * @return ListenerInterface[]
     */
    protected function dispatchWithResult(ListenerInterface $listener, $result): array
    {
        $deferred = [];

        if ($listener->suites($result)) {
            if ($listener->isSynchronous()) {
                $listener->getActionDefinition($result)->run();
            } else {
                $deferred[] = $listener;
            }
        }

        return $deferred;
    }
}
