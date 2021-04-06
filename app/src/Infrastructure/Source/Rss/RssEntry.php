<?php

declare(strict_types=1);

namespace Resender\Infrastructure\Source\Rss;

use DateTime;

final class RssEntry
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

    public function getHash(): string
    {
        return md5(
            json_encode(
                [
                    $this->title,
                    $this->description,
                    $this->updated,
                    $this->link,
                ],
                JSON_THROW_ON_ERROR
            )
        );
    }
}
