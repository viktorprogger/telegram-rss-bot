<?php

declare(strict_types=1);

namespace rssBot\models\messages;

use JsonSerializable;

class TextMessage implements JsonSerializable
{
    private string $text;
    private TextMessageType $type;

    /**
     * TextMessage constructor.
     *
     * @param string $text
     * @param int|TextMessageType|null $type
     */
    public function __construct(string $text, $type = null)
    {
        if (is_int($type)) {
            $type = new TextMessageType($type);
        }

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
