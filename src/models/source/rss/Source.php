<?php

declare(strict_types=1);

namespace rssBot\models\source\rss;

use FeedIo\FeedIo;
use Laminas\Feed\Reader\Reader;
use rssBot\models\source\SourceInterface;
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

    public function __construct(string $title, string $url, FeedIo $reader)
    {
        $this->title = $title;
        $this->url = $url;
        $this->reader = $reader;
    }

    /**
     * @inheritDoc
     */
    public function getItems(): iterable
    {
        /** @noinspection StaticInvocationViaThisInspection */
        $itemsSource = $this->reader->read($this->url)->getFeed();


    }

    public function attachFilter(Validator $validator): void
    {
        $this->filters[] = $validator;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
