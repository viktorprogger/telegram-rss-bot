<?php

declare(strict_types=1);

namespace Resender\Domain\Source\Rss;

use FeedIo\Feed\ItemInterface as FeedItemInterface;
use FeedIo\FeedIo;
use InvalidArgumentException;
use Resender\Domain\Target\TargetIdInterface;

final class Source
{
    private TargetIdInterface $targets;

    public function __construct(
        private string $url,
        private FeedIo $reader,
        TargetIdInterface ...$targets
    ) {
        if ($targets === []) {
            throw new InvalidArgumentException('There must be at least one target for a source');
        }

        $this->targets = $targets;
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

    /**
     * @return TargetIdInterface[]
     */
    public function getTargetIds(): array
    {
        return $this->targets;
    }
}
