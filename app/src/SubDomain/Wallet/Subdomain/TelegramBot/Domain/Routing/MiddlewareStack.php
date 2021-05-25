<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\Routing;

use Resender\Domain\Client\Telegram\TelegramMessage;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\ChatState;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\StateHandler\HandlerInterface;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\TelegramRequest;
use RuntimeException;

final class MiddlewareStack implements HandlerInterface
{
    /**
     * Contains a stack of middleware wrapped in handlers.
     * Each handler points to the handler of middleware that will be processed next.
     *
     * @var HandlerInterface|null stack of middleware
     */
    private ?HandlerInterface $stack = null;

    public function __construct(array $middlewares, HandlerInterface $fallbackHandler)
    {
        $handler = $fallbackHandler;

        foreach ($middlewares as $middleware) {
            $handler = $this->wrap($middleware, $handler);
        }
    }

    public function handle(ChatState $state, TelegramRequest $request): TelegramMessage
    {
        if ($this->isEmpty()) {
            throw new RuntimeException('Stack is empty.');
        }

        /** @psalm-suppress PossiblyNullReference */
        return $this->stack->handle($state, $request);
    }

    public function isEmpty(): bool
    {
        return $this->stack === null;
    }

    /**
     * Wraps handler by middlewares
     */
    private function wrap(
        MiddlewareInterface $middleware,
        HandlerInterface $handler
    ): HandlerInterface {
        return new class($middleware, $handler) implements HandlerInterface {
            public function __construct(
                private MiddlewareInterface $middleware,
                private HandlerInterface $handler,
            ) {
            }

            public function handle(ChatState $state, TelegramRequest $request): TelegramMessage
            {
                return $this->middleware->handle($state, $request, $this->handler);
            }
        };
    }
}
