<?php

declare(strict_types=1);

namespace rssBot\models\sender;

use rssBot\models\sender\messages\MessageInterface;
use rssBot\models\source\ItemInterface;
use rssBot\models\source\SourceInterface;

interface SenderInterface
{
    public function getCode(): string;

    public function send($message): void;

    public function suitsSource(ItemInterface $message): bool;

    public function suitsMessage(MessageInterface $message): bool;
}
