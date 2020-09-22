<?php

declare(strict_types=1);

namespace rssBot\models\messages;

use InvalidArgumentException;

class TextMessageType
{
    public const PLAIN_TEXT = 1;
    public const MARKDOWN = 2;
    public const HTML = 3;
    private int $type;

    public function __construct(int $type)
    {
        if (!in_array($type, static::all(), true)) {
            throw new InvalidArgumentException('The given type is not supported');
        }

        $this->type = $type;
    }

    /**
     * @return int[]
     */
    public static function all(): array
    {
        return [
            static::PLAIN_TEXT,
            static::MARKDOWN,
            static::HTML,
        ];
    }

    public static function plainText(): self
    {
        return new static(static::PLAIN_TEXT);
    }

    public static function markdown(): self
    {
        return new static(static::MARKDOWN);
    }

    public static function html(): self
    {
        return new static(static::HTML);
    }

    public function current(): int
    {
        return $this->type;
    }

    public function isPlainText(): bool
    {
        return $this->type === static::PLAIN_TEXT;
    }

    public function isMarkdown(): bool
    {
        return $this->type === static::MARKDOWN;
    }

    public function isHtml(): bool
    {
        return $this->type === static::HTML;
    }
}
