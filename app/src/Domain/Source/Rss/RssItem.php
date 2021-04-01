<?php

declare(strict_types=1);

namespace Resender\Domain\Source\Rss;

use DateTime;

final class RssItem
{
    public function __construct(
        private string $title,
        private string $description,
        private ?DateTime $updated,
        private ?string $link,
    ) {
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
        return $this->updated;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }
}
