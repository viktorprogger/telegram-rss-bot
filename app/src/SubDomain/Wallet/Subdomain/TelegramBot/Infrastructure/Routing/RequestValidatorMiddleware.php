<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Infrastructure\Routing;

use Resender\Domain\Client\Telegram\TelegramMessage;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\ChatState;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\Routing\MiddlewareInterface;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\StateHandler\HandlerInterface;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\TelegramRequest;
use SplObjectStorage;

final class RequestValidatorMiddleware implements MiddlewareInterface
{
    /**
     * RequestValidatorMiddleware constructor.
     *
     * @param RequestValidatorInterface $config
     */
    public function __construct(private SplObjectStorage $config)
    {
    }

    public function handle(ChatState $state, TelegramRequest $request, HandlerInterface $handler): TelegramMessage
    {
        // TODO надо разнести это все на разные классы мидлварей, реализующие один интерфейс
        if (isset($this->config[$state])) {
            foreach ($this->config[$state]->getRules() as $rule) {
                if (!$rule->validate($request)->isValid()) {
                    return $this->config[$state]->getErrorMessage();
                }
            }
        }

        return $handler->handle($state, $request);
    }
}
