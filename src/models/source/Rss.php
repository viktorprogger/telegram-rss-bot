<?php

declare(strict_types=1);

namespace rssBot\models\source;

use Laminas\Feed\Reader\Reader;
use Yiisoft\Validator\Validator;

class Rss implements SourceInterface
{
    private string $title;
    private string $url;
    private Reader $reader;
    /**
     * @var Validator[]
     */
    private array $filters = [];

    public function __construct(string $title, string $url, Reader $reader)
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
        $itemsSource = $this->reader->import($this->url);


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
