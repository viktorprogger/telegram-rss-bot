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

    public function suits($message): bool
    {
        if ($message instanceof ItemInterface) {
            $filter = $this->preFilters;
        } elseif ($message instanceof MessageInterface) {
            $filter = $this->postFilters;
        } else {
            $type = is_object($message) ? get_class($message) : gettype($message);
            $error = sprintf('%s or %s expected, %s given', ItemInterface::class, MessageInterface::class, $type);

            throw new InvalidArgumentException($error);
        }

        return $filter->validate($message)->isValid();
    }

    public function getCode(): string
    {
        return static::class;
    }
}
