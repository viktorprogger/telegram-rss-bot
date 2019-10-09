<?php
declare(strict_types=1);

namespace rssBot\dto;

interface FeedItemInterface
{
    public function getSiteName(): string;
    public function getTitle(): string;
    public function getBody(): string;
    public function getUrl(): string;
    public function getHash(): string;
}
