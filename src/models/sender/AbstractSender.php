<?php

declare(strict_types=1);

namespace rssBot\models\sender;

use InvalidArgumentException;
use rssBot\models\sender\converter\ConverterInterface;
use rssBot\models\sender\messages\MessageInterface;
use rssBot\models\source\ItemInterface;
use Yiisoft\Validator\Rules;

abstract class AbstractSender implements SenderInterface
{
    protected Rules $preFilters;
    protected Rules $postFilters;

    public function __construct(Rules $preFilters, Rules $postFilters)
    {
        $this->preFilters = $preFilters;
        $this->postFilters = $postFilters;
    }

    public function suitsSource(ItemInterface $message): bool
    {
        return $this->preFilters->validate($message)->isValid();
    }

    public function suitsMessage(MessageInterface $message): bool
    {
        return $this->postFilters->validate($message)->isValid();
    }

    public function getCode(): string
    {
        return static::class;
    }
}
