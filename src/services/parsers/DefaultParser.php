<?php
declare(strict_types=1);

namespace rssBot\services\parsers;

use rssBot\dto\FeedItemFactory;
use Zend\Feed\Reader\Reader;

class DefaultParser implements ParserInterface
{
    public string $itemClass;

    private Reader $feed;
    /**
     * @var string
     */
    private string $title;
    /**
     * @var string
     */
    private string $url;

    public function __construct(Reader $feed)
    {
        $this->feed = $feed;
    }

    public function parse(): array
    {
        $result = [];

        /** @noinspection StaticInvocationViaThisInspection */
        foreach ($this->feed->import($this->url) as $item) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $result[] = FeedItemFactory::createItem($this->title, $this->itemClass, $item);
        }

        return $result;
    }
}
