<?php
declare(strict_types=1);

namespace rssBot\services\formatters;

use rssBot\dto\FeedItemInterface;

class TelegramDefaultFormatter implements FormatterInterface
{
    public function formatMessage(FeedItemInterface $item): string
    {
        $result = '# ' . $item->getTitle() . "\n";
        $result .= '_' . $item->getSiteName() . "_\n\n";
        $result .= $item->getBody() . "\n\n";
        $result .= "[Перейти](" . $item->getUrl() . ")";

        return $result;
    }
}
