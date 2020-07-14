<?php
declare(strict_types=1);

namespace rssBot\services\formatters;

use rssBot\dto\FeedItemInterface;

interface FormatterInterface
{
    public function formatMessage(FeedItemInterface $item): string;
}
