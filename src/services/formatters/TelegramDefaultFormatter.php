<?php
declare(strict_types=1);

namespace rssBot\services\formatters;

use rssBot\dto\FeedItemInterface;

class TelegramDefaultFormatter implements FormatterInterface
{
    public function formatMessage(FeedItemInterface $item): string
    {
        $body = $item->getBody();
        $body = preg_replace('/([*_\[\]()])/', '\\$1', $body);

        $result = '*' . $item->getTitle() . "*\n";
        $result .= '_' . $item->getSiteName() . "_\n\n";
        $result .= $body . "\n\n";
        $result .= "[Читать дальше ->](" . $item->getUrl() . ")";

        return $result;
    }
}
