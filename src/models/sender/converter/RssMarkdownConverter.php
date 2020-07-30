<?php

declare(strict_types=1);

namespace rssBot\models\sender\converter;

use InvalidArgumentException;
use rssBot\models\sender\messages\TextMessage;
use rssBot\models\sender\messages\TextMessageType;
use rssBot\models\source\ItemInterface;
use rssBot\models\source\rss\ItemInterface as RssItemInterface;

class RssMarkdownConverter implements ConverterInterface
{
    /**
     * @param ItemInterface|RssItemInterface $item
     *
     * @return TextMessage
     */
    public function convert(ItemInterface $item): TextMessage
    {
        if (!$item instanceof RssItemInterface) {
            throw new InvalidArgumentException('Given item must implement ' . RssItemInterface::class);
        }

        $body = html_entity_decode($item->getDescription());
        $body = strip_tags($body);
        $body = trim($body);

        $result = '*' . $item->getTitle() . "*\n";
        $result .= '_' . $item->getTitle() . "_\n\n";
        $result .= $body . "\n\n";

        if ($item->getLink() !== null) {
            $result .= "[Читать дальше ->](" . $item->getLink() . ")";
        }

        return new TextMessage($result, TextMessageType::markdown());
    }
}
