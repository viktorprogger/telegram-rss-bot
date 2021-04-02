<?php

declare(strict_types=1);

namespace Resender\Infrastructure\Target\Telegram;

final class TelegramMessage
{
    public function __construct(
        private string $text,
        private MessageFormat $format,
    ) {
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return MessageFormat
     */
    public function getFormat(): MessageFormat
    {
        return $this->format;
    }
}
