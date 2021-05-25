<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\Routing;

use JetBrains\PhpStorm\Pure;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\ChatState;

final class Route
{
    private array $middlewares = [];

    public function __construct(private ChatState $state)
    {
    }

    #[Pure]
    public static function create(ChatState $state): self
    {
        return new self($state);
    }

    public function withMiddleware(MiddlewareInterface $middleware): self
    {
        $instance = clone $this;
        array_unshift($instance->middlewares, $middleware);

        return $instance;
    }

    public function getState(): ChatState
    {
        return $this->state;
    }

    /**
     * @return MiddlewareInterface[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}
