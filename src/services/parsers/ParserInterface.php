<?php
declare(strict_types=1);

namespace rssBot\services\parsers;

use rssBot\dto\FeedItemInterface;

interface ParserInterface
{
    /**
     * @return FeedItemInterface[]
     */
    public function parse(): array;
}
