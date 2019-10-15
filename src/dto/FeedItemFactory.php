<?php
declare(strict_types=1);

namespace rssBot\dto;

use yii\base\NotSupportedException;
use Zend\Feed\Reader\Entry\EntryInterface;

class FeedItemFactory
{
    /**
     * @param string|null              $siteTitle
     * @param string|FeedItemInterface $class
     * @param EntryInterface           $feedItem
     *
     * @return FeedItemInterface
     */
    public static function createItem(?string $siteTitle, string $class, EntryInterface $feedItem): FeedItemInterface
    {
        if ($class === FeedItem::class) {
            return new FeedItem($siteTitle, $feedItem->getTitle(), $feedItem->getDescription(), $feedItem->getLink());
        }

        /** @noinspection PhpUnhandledExceptionInspection */
        throw new NotSupportedException(sprintf('Feed item type is not supported: %s', $class));
    }
}
