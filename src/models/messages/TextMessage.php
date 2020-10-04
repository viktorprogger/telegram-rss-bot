<?php

declare(strict_types=1);

namespace rssBot\models\messages;

use JsonSerializable;
use rssBot\models\source\HashAwareInterface;

class TextMessage implements JsonSerializable, HashAwareInterface
{
    private string $text;
    private TextMessageType $type;
    private ?string $hash;

    public function __construct(string $text, $type = null, ?string $hash = null)
    {
        if (is_int($type)) {
            $type = new TextMessageType($type);
        }

        $this->text = $text;
        $this->type = $type ?? TextMessageType::plainText();
        $this->hash = $hash;
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

    public function getHash(): string
    {
        return $this->hash ?? '';
    }
}
