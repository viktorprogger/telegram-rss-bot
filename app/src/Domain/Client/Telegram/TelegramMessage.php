<?php

declare(strict_types=1);

namespace Resender\Domain\Client\Telegram;

final class TelegramMessage
{
    /**
     * @param InlineKeyboardButton[] $inlineKeyboard
     */
    public function __construct(
        private string $text,
        private MessageFormat $format,
        private array $inlineKeyboard = [],
    ) {
    }

    /**
     * @return InlineKeyboardButton[]
     */
    public function getInlineKeyboard(): array
    {
        return $this->inlineKeyboard;
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
