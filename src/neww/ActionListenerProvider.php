<?php

declare(strict_types=1);

namespace rssBot\neww;

use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use rssBot\action\ActionInterface;
use Yiisoft\Injector\Injector;

final class ActionListenerProvider implements ActionListenerProviderInterface
{
    private array $resolved = [];
    private array $listeners;
    private ContainerInterface $container;
    private Injector $injector;

    public function __construct(array $listeners, ContainerInterface $container, Injector $injector)
    {
        $this->listeners = $listeners;
        $this->container = $container;
        $this->injector = $injector;
    }

    /**
     * @inheritDoc
     */
    public function getListenersForAction(ActionInterface $action): iterable
    {
        yield from $this->getForEvents(get_class($action));
        yield from $this->getForEvents(...array_values(class_parents($action)));
        yield from $this->getForEvents(...array_values(class_implements($action)));
    }

    /**
     * @param string ...$eventClassNames
     *
     * @return ActionInterface[]
     */
    private function getForEvents(string ...$eventClassNames): iterable
    {
        foreach ($eventClassNames as $eventClassName) {
            if (!isset($this->resolved[$eventClassName])) {
                $this->resolved[$eventClassName] = $this->resolve($eventClassName);
            }

            yield from $this->resolved[$eventClassName];
        }
    }

    private function resolve(string $eventClassName): array
    {
        $result = [];

        foreach ($this->listeners[$eventClassName] ?? [] as $listener) {
            $result[] = $this->convert($listener);
        }

        return $result;
    }

    private function convert($listener): ActionInterface
    {
        //TODO This must return ListenerInterface, not ActionInterface. It should be either created with factory or passed directly

        if ($listener instanceof ActionInterface) {
            return $listener;
        }

        if (is_callable($listener)) {
            return $this->injector->invoke($listener);
        }

        if (is_string($listener) && $this->container->has($listener)) {
            return $this->container->get($listener);
        }

        throw new InvalidArgumentException('Invalid listener');
    }
}
