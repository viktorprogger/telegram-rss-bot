<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain;

use Resender\Domain\Client\Telegram\TelegramMessage;
use SplObjectStorage;

class RequestValidatorMiddleware implements MiddlewareInterface
{
    /**
     * RequestValidatorMiddleware constructor.
     *
     * @param list<ChatState, RequestValidatorInterface> $config
     */
    public function __construct(private SplObjectStorage $config)
    {
    }

    public function handle(ChatState $state, TelegramRequest $request, MiddlewareInterface $middleware): TelegramMessage
    {
        if (isset($this->config[$state])) {
            foreach ($this->config[$state]->getRules() as $rule) {
                if (!$rule->validate($request)->isValid()) {
                    return $this->config[$state]->getErrorMessage();
                }
            }
        }

        // TODO middleware should be taken from somewhere
        return $middleware->handle($state, $request, $middleware);
    }
}
