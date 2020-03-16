<?php

declare(strict_types=1);

namespace rssBot\models\sender;

use InvalidArgumentException;

class SenderType
{
    public const TELEGRAM = 1;

    private int $type;

    public function __construct(int $type)
    {
        if (!in_array($type, self::all(), true)) {
            throw new InvalidArgumentException('Given type is not supported');
        }
    }

    public function current(): int
    {
        return $this->type;
    }

    public static function all(): array
    {
        return [self::TELEGRAM];
    }

    public static function telegram(): self
    {
        return new static(self::TELEGRAM);
    }
}
