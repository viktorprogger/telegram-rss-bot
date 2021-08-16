<?php

declare(strict_types=1);

namespace Resender\SubDomain\Rss\Infrastructure\Source;

use FeedIo\Feed\ItemInterface as FeedItemInterface;
use FeedIo\FeedIo;
use FeedIo\Reader\ReadErrorException;
use InvalidArgumentException;
use Resender\SubDomain\Rss\Domain\Source\Entry;
use Resender\SubDomain\Rss\Domain\Source\SourceInterface;
use Resender\SubDomain\Rss\Domain\Target\TargetIdInterface;

final class Source implements SourceInterface
{
    private array $targets;

    public function __construct(
        private string $title,
        private string $url,
        private FeedIo $reader,
        TargetIdInterface ...$targets
    ) {
        if ($targets === []) {
            throw new InvalidArgumentException('There must be at least one target for a source');
        }

        $this->targets = $targets;
    }

    public function getId(): string
    {
        return $this->url;
    }

    public function getItems(): iterable
    {
        try {
            /** @var FeedItemInterface[] $itemsSource */
            $itemsSource = $this->reader->read($this->url)->getFeed();

            foreach ($itemsSource as $item) {
                yield new Entry(
                    $this->title,
                    $item->getTitle(),
                    $item->getContent(),
                    $item->getLastModified(),
                    $item->getLink()
                );
            }
        } catch (ReadErrorException) {
        }
    }

    public function getTargetIds(): array
    {
        return $this->targets;
    }
}
