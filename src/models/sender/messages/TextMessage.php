<?php

declare(strict_types=1);

namespace rssBot\models\sender\messages;

class TextMessage extends AbstractMessage
{
    private string $text;
    private TextMessageType $type;

    public function __construct(string $text, ?TextMessageType $type = null)
    {
        $this->text = $text;
        $this->type = $type ?? TextMessageType::plainText();
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getType(): TextMessageType
    {
        return $this->type;
    }

    public function jsonSerialize(): array
    {
        return [
            'class' => static::class,
            'text' => $this->text,
            'type' => $this->type->current(),
        ];
    }
}
