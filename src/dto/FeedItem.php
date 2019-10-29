<?php
declare(strict_types=1);

namespace rssBot\dto;

class FeedItem implements FeedItemInterface
{
    /**
     * @var string
     */
    protected string $siteName;
    /**
     * @var string
     */
    protected string $title;
    /**
     * @var string
     */
    protected string $body;
    /**
     * @var string
     */
    protected string $url;

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
        $body = $this->body;
        $body = htmlspecialchars_decode($body);
        $body = strip_tags($body);
        $body = trim($body);

        return $body;
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
