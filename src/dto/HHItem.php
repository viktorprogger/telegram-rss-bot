<?php
declare(strict_types=1);

namespace rssBot\dto;

final class HHItem extends FeedItem
{
    public function getBody(): string
    {
        $body = $this->body;
        $body = htmlspecialchars_decode($body);
        $body = str_replace(['<p>', '</p>'], ['', "\n"], $body);
        $body = trim($body);

        return $body;
    }
}
