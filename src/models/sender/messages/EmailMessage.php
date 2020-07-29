<?php

declare(strict_types=1);

namespace rssBot\models\sender\messages;

use JsonSerializable;

class EmailMessage extends AbstractMessage implements JsonSerializable
{
    private string $theme;
    private string $body;

    public function __construct(?string $theme, ?string $body)
    {
        $this->theme = $theme ?? '';
        $this->body = $body ?? '';
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getTheme(): string
    {
        return $this->theme;
    }
}
