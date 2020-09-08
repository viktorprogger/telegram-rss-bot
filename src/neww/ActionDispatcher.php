<?php

declare(strict_types=1);

namespace rssBot\neww;

use RuntimeException;
use Yiisoft\Yii\Queue\Queue;

class ActionDispatcher implements ActionDispatcherInterface
{
    private ActionListenerProviderInterface $provider;
    private ActionFactoryInterface $factory;
    private Queue $queue;

    public function __construct(
        ActionListenerProviderInterface $provider,
        ActionFactoryInterface $factory,
        Queue $queue
    )
    {
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
                $deferred[] = $this->dispatchCollection($listener, $result);
            } else {
                $deferred[] = $this->dispatchWithResult($listener, $result);
            }
        }

        $this->dispatchDeferred(array_merge(...$deferred));
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
                $deferred[] = $this->dispatchCollection($listener, $resultItem);
            } else {
                $deferred[] = $this->dispatchWithResult($listener, $resultItem);
            }
        }

        return array_merge(...$deferred);
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
                $listener->getAction()->run($result);
            } else {
                $deferred[] = [$listener, $result];
            }
        }

        return $deferred;
    }

    /**
     * @param array $deferred
     */
    private function dispatchDeferred(array $deferred): void
    {
        if ($deferred !== [] && $this->queue === null) {
            throw new RuntimeException('Queue must be set to use deferred action listeners');
        }

        /** @var ListenerInterface $listener */
        foreach ($deferred as [$listener, $result]) {
            $this->queue->push(
                $this->factory->createPayload(
                    $listener->getAction(),
                    $result
                )
            );
        }
    }
}
