<?php

declare(strict_types=1);

namespace rssBot\models\source\rss;

use DateTime;
use FeedIo\Feed\ItemInterface as FeedItemInterface;
use rssBot\models\source\HashAwareInterface;
use rssBot\models\source\SourceInterface;
use Yiisoft\Validator\MissingAttributeException;

class Item implements ItemInterface, HashAwareInterface
{
    private FeedItemInterface $feedItem;
    private SourceInterface $source;

    public function __construct(FeedItemInterface $feedItem, SourceInterface $source)
    {
        $this->feedItem = $feedItem;
        $this->source = $source;
    }

    public function getHash(): string
    {
        return md5($this->feedItem->getPublicId() . '|' . $this->feedItem->getLink());
    }

    public function __toString(): string
    {
        // FIXME NullPointerException
        return $this->feedItem->getTitle() . PHP_EOL
            . $this->feedItem->getLastModified()->format('Y.m.d H:i:s') . PHP_EOL . PHP_EOL
            . $this->feedItem->getDescription() . PHP_EOL
            . $this->feedItem->getLink();
    }

    public function getSource(): SourceInterface
    {
        return $this->source;
    }

    public function getTitle(): string
    {
        return $this->feedItem->getTitle();
    }

    public function getDescription(): string
    {
        return $this->feedItem->getDescription();
    }

    public function getLastModified(): ?DateTime
    {
        return $this->feedItem->getLastModified();
    }

    public function getLink(): ?string
    {
        return $this->feedItem->getLink();
    }

    public function getAttributeValue(string $attribute)
    {
        if ($this->hasAttribute($attribute)) {
            $method = "get$attribute";

            return $this->$method();
        }

        $message = sprintf('There is no attribute "%s" in class %s', $attribute, static::class);

        throw new MissingAttributeException("");
    }

    public function hasAttribute(string $attribute): bool
    {
        return in_array($attribute, ['link', 'lastModified', 'description', 'title']);
    }
}
