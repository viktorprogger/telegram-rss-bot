<?php
declare(strict_types=1);

namespace rssBot\services\formatters;

use rssBot\dto\FeedItemInterface;

class TelegramDefaultFormatter implements FormatterInterface
{
    public function formatMessage(FeedItemInterface $item): string
    {
        $body = $item->getBody();

        $result = '*' . $item->getTitle() . "*\n";
        $result .= '_' . $item->getSiteName() . "_\n\n";
        $result .= $body . "\n\n";
        $result .= "[Перейти](" . $item->getUrl() . ")";

        return $result;
    }
}
