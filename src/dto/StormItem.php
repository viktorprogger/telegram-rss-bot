<?php
declare(strict_types=1);

namespace rssBot\dto;

class StormItem extends FeedItem
{
    public function getBody(): string
    {
        $body = parent::getBody();
        $body = str_replace('&#8230; Continue reading &#8594;', '', $body);
        $body .= '…';

        return $body;
    }
}
