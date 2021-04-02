<?php

declare(strict_types=1);

namespace Resender\Infrastructure\Source\Rss;

use FeedIo\Feed\ItemInterface as FeedItemInterface;
use FeedIo\FeedIo;
use InvalidArgumentException;
use Resender\Domain\Source\SourceInterface;
use Resender\Domain\Target\TargetIdInterface;

final class Source implements SourceInterface
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

    public function getItems(): iterable
    {
        /** @var FeedItemInterface[] $itemsSource */
        $itemsSource = $this->reader->read($this->url)->getFeed();

        foreach ($itemsSource as $item) {
            yield new RssEntry($item->getTitle(), $item->getDescription(), $item->getLastModified(), $item->getLink());
        }
    }

    public function getTargetIds(): array
    {
        return $this->targets;
    }
}
