<?php
declare(strict_types=1);

namespace rssBot\services\parsers;

use rssBot\dto\FeedItem;
use rssBot\dto\FeedItemFactory;
use Zend\Feed\Reader\Reader;

class RssParser implements ParserInterface
{
    public string $itemClass = FeedItem::class;

    private Reader $feed;
    /**
     * @var string
     */
    public string $title;
    /**
     * @var string
     */
    public string $url;

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
