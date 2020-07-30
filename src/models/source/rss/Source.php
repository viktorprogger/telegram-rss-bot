<?php

declare(strict_types=1);

namespace rssBot\models\source\rss;

use FeedIo\FeedIo;
use rssBot\models\source\SourceInterface;
use Yiisoft\Factory\Factory;
use Yiisoft\Validator\Validator;

class Source implements SourceInterface
{
    private string $title;
    private string $url;
    private FeedIo $reader;
    /**
     * @var Validator[]
     */
    private array $filters = [];
    private string $code;
    /**
     * @var Factory
     */
    private Factory $factory;

    public function __construct(string $title, string $code, string $url, FeedIo $reader, Factory $factory)
    {
        $this->title = $title;
        $this->code = $code;
        $this->url = $url;
        $this->reader = $reader;
        $this->factory = $factory;
    }

    /**
     * @inheritDoc
     */
    public function getItems(): iterable
    {
        /** @var \FeedIo\Feed\ItemInterface[] $itemsSource */
        $itemsSource = $this->reader->read($this->url)->getFeed();

        foreach ($itemsSource as $item) {
            $item->getTitle();
            $item->getDescription();
            $item->getLink();
            $config = [
                '__class' => Item::class,
                '__construct()' => [
                    $this->getCode(),
                    $item->getPublicId(),
                    $item->getLink(),
                    $item->getTitle(),
                    $item->getDescription(),
                    $item->getLastModified() ? $item->getLastModified()->getTimestamp() : null,
                ],
            ];

            yield $this->factory->create($config);
        }
    }

    public function attachFilter(Validator $validator): void
    {
        $this->filters[] = $validator;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
