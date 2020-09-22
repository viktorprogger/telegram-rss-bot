<?php

declare(strict_types=1);

namespace rssBot\action;

use InvalidArgumentException;
use rssBot\models\sender\messages\TextMessage;
use rssBot\models\sender\messages\TextMessageType;
use rssBot\models\source\rss\ItemInterface;
use rssBot\models\source\rss\ItemInterface as RssItemInterface;
use rssBot\neww\ActionInterface;

class ConvertRssMarkdownAction implements ActionInterface
{
    public function run($item = null)
    {
        if (!$item instanceof RssItemInterface) {
            throw new InvalidArgumentException('Given item must implement ' . RssItemInterface::class);
        }

        $body = html_entity_decode($item->getDescription());
        $body = strip_tags($body);
        $body = trim($body);

        $result = '*' . $item->getTitle() . "*\n";
        $result .= $body . "\n\n";

        if ($item->getLink() !== null) {
            $result .= "[Читать дальше ->](" . $item->getLink() . ")";
        }

        return new TextMessage($result, TextMessageType::markdown());
    }
}
