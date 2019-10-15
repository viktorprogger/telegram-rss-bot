<?php
declare(strict_types=1);

namespace rssBot\services\senders;

use rssBot\dto\FeedItemInterface;

interface SenderInterface
{
    public function send(FeedItemInterface $item, string $chatId);
}
