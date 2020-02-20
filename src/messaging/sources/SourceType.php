<?php

declare(strict_types=1);

namespace rssBot\sources;

class SourceType
{
    public const RSS = 1;

    private int $type;

    public function __construct(int $type)
    {
        if (!in_array($type, self::all(), true)) {
            throw new \InvalidArgumentException('Given type is not supported');
        }
    }

    public static function all(): array
    {
        return [self::RSS];
    }

    public static function rss(): self
    {
        return new static(self::RSS);
    }
}