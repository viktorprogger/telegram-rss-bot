<?php

declare(strict_types=1);

namespace rssBot\models\source\rss;

use FeedIo\Feed\ItemInterface as FeedItemInterface;
use rssBot\models\source\ItemInterface;

class Item implements ItemInterface
{
    private FeedItemInterface $feedItem;

    public function __construct(FeedItemInterface $feedItem)
    {
        $this->feedItem = $feedItem;
    }

    public function getHash(): string
    {
        return md5($this->feedItem->getPublicId() . '|' . $this->feedItem->getLink());
    }

    public function __toString(): string
    {
        $result = $this->feedItem->getTitle() . PHP_EOL
            . $this->feedItem->getLastModified()->format('Y.m.d H:i:s') . PHP_EOL . PHP_EOL
            . $this->feedItem->getDescription();
    }
}
