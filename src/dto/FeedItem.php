<?php
declare(strict_types=1);

namespace rssBot\dto;

class FeedItem implements FeedItemInterface
{
    /**
     * @var string
     */
    private string $siteName;
    /**
     * @var string
     */
    private string $title;
    /**
     * @var string
     */
    private string $body;
    /**
     * @var string
     */
    private string $url;

    public function __construct(string $siteName, string $title, string $body, string $url)
    {
        $this->siteName = $siteName;
        $this->title = $title;
        $this->body = $body;
        $this->url = $url;
    }

    public function getSiteName(): string
    {
        return $this->siteName;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getHash(): string
    {
        return md5($this->getUrl());
    }
}
