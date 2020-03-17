<?php

declare(strict_types=1);

namespace rssBot\models\source\rss;

use DateTime;
use FeedIo\Feed\ItemInterface as FeedItemInterface;
use rssBot\models\source\SourceInterface;

class Item implements ItemInterface
{
    private FeedItemInterface $feedItem;
    private SourceInterface $source;

    public function __construct(FeedItemInterface $feedItem, SourceInterface $source)
    {
        $this->feedItem = $feedItem;
        $this->source = $source;
    }

    public function getHash(): string
    {
        return md5($this->feedItem->getPublicId() . '|' . $this->feedItem->getLink());
    }

    public function __toString(): string
    {
        return $this->feedItem->getTitle() . PHP_EOL
            . $this->feedItem->getLastModified()->format('Y.m.d H:i:s') . PHP_EOL . PHP_EOL
            . $this->feedItem->getDescription() . PHP_EOL
            . $this->feedItem->getLink();
    }

    public function getSource(): SourceInterface
    {
        return $this->source;
    }

    public function getTitle(): string
    {
        return $this->feedItem->getTitle();
    }

    public function getDescription(): string
    {
        return $this->feedItem->getDescription();
    }

    public function getLastModified(): ?DateTime
    {
        return $this->feedItem->getLastModified();
    }

    public function getLink(): ?string
    {
        return $this->feedItem->getLink();
    }
}
