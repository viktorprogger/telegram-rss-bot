<?php

declare(strict_types=1);

namespace rssBot\models\sender\converter;

use rssBot\models\source\rss\ItemInterface;

class RssMarkdownConverter
{
    public function convert(ItemInterface $item): string
    {
        $body = html_entity_decode($item->getDescription());
        $body = strip_tags($body);
        $body = trim($body);

        $result = '*' . $item->getTitle() . "*\n";
        $result .= '_' . $item->getSource()->getTitle() . "_\n\n";
        $result .= $body . "\n\n";

        if ($item->getLink() !== null) {
            $result .= "[Читать дальше ->](" . $item->getLink() . ")";
        }

        return $result;
    }
}
