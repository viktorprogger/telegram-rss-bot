<?php

declare(strict_types=1);

namespace rssBot\models\sender;

interface SenderInterface
{
    public function getCode(): string;

    public function send($message): void;

    public function suits($message): bool;
}
