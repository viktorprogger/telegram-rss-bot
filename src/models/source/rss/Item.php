<?php

declare(strict_types=1);

namespace rssBot\models\source\rss;

use DateTime;
use rssBot\models\source\HashAwareInterface;

class Item implements ItemInterface, HashAwareInterface
{
    private ?string $id;
    private ?string $link;
    private ?string $title;
    private ?string $description;
    private ?int $lastModified;

    public function __construct(
        ?string $id = null,
        ?string $link = null,
        ?string $title = null,
        ?string $description = null,
        ?int $lastModified = null
    ) {
        $this->id = $id;
        $this->link = $link;
        $this->title = $title;
        $this->description = $description;
        $this->lastModified = ($lastModified === null ? $lastModified : new DateTime($lastModified));
    }

    public function getHash(): string
    {
        return md5(json_encode($this, JSON_THROW_ON_ERROR));
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getLastModified(): ?DateTime
    {
        return $this->lastModified;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function getAttributeValue(string $attribute)
    {
        return $this->$attribute;
    }

    public function hasAttribute(string $attribute): bool
    {
        return property_exists($this, $attribute);
    }

    public function jsonSerialize()
    {
        return [
            $this->id,
            $this->link,
            $this->title,
            $this->description,
            $this->lastModified,
        ];
    }
}
