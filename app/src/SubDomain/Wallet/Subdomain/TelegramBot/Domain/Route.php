<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain;

use JetBrains\PhpStorm\Pure;

final class Route
{
    protected array $middlewares = [];

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
}
