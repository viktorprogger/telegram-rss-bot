<?php

declare(strict_types=1);

namespace rssBot\Entity;

class RssCache
{
    protected int $id;
    protected string $hash;
    protected string $destination;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function setHash(string $hash): void
    {
        $this->hash = $hash;
    }

    public function getDestination(): string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): void
    {
        $this->destination = $destination;
    }
}
