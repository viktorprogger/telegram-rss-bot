<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\Routing;

use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\ChatState;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\StateHandler\HandlerInterface;
use SplObjectStorage;
use WeakReference;

final class RouteCollection
{
    private SplObjectStorage $config;
    private SplObjectStorage $built;

    /**
     * @param Route[] $routes
     */
    public function __construct(
        array $routes,
        private HandlerInterface $fallbackHandler,
    ) {
        $this->config = new SplObjectStorage();
        $this->built = new SplObjectStorage();

        foreach ($routes as $route) {
            $this->config[$route->getState()] = $route->getMiddlewares();
        }
    }

    public function find(ChatState $state): HandlerInterface
    {
        $stack = $this->getStack($state);

        if ($stack === null || $stack->isEmpty()) {
            return  $this->fallbackHandler;
        }

        return $stack;
    }

    private function getStack(ChatState $state): ?MiddlewareStack
    {
        if (!isset($this->config[$state])) {
            return null;
        }

        $stack = null;
        if (isset($this->built[$state])) {
            $stack = $this->built[$state]->get();
        }

        if ($stack === null) {
            $stack = new MiddlewareStack($this->config[$state], $this->fallbackHandler);
            $this->built[$state] = WeakReference::create($stack);
        }

        return $stack;
    }
}
