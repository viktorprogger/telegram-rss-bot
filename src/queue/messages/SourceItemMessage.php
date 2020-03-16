<?php

declare(strict_types=1);

namespace rssBot\queue\messages;

use rssBot\models\sender\SenderInterface;
use rssBot\models\source\ItemInterface;

class SourceItemMessage
{
    private ItemInterface $item;
    private SenderInterface $sender;

    public function __construct(ItemInterface $item, SenderInterface $sender)
    {
        $this->item = $item;
        $this->sender = $sender;
    }

    public function getItem(): ItemInterface
    {
        return $this->item;
    }

    public function getSender(): SenderInterface
    {
        return $this->sender;
    }
}
