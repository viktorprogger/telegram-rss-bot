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
        $itemsSource = $this->reader->read($this->url)->getFeed();

        foreach ($itemsSource as $item) {
            $config = [
                '__class' => ItemInterface::class,
                '__construct()' => [$item, $this],
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
