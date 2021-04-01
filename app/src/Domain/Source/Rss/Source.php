<?php

declare(strict_types=1);

namespace Resender\Domain\Source\Rss;

use FeedIo\Feed\ItemInterface as FeedItemInterface;
use FeedIo\FeedIo;

final class Source
{
    public function __construct(
        private string $url,
        private FeedIo $reader
    ) {
    }

    /**
     * @return RssItem[]
     */
    public function getItems(): iterable
    {
        /** @var FeedItemInterface[] $itemsSource */
        $itemsSource = $this->reader->read($this->url)->getFeed();

        foreach ($itemsSource as $item) {
            yield new RssItem($item->getTitle(), $item->getDescription(), $item->getLastModified(), $item->getLink());
        }
    }
}
