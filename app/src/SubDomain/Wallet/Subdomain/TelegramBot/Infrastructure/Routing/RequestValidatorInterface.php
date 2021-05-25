<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Infrastructure\Routing;

use Resender\Domain\Client\Telegram\TelegramMessage;
use Yiisoft\Validator\Rule;

interface RequestValidatorInterface
{
    /**
     * @return Rule[]
     */
    public function getRules(): iterable;

    public function getErrorMessage(): TelegramMessage;
}
