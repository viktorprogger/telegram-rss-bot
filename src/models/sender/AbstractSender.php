<?php

declare(strict_types=1);

namespace rssBot\models\sender;

use rssBot\models\source\ItemInterface;

class AbstractSender implements SenderInterface
{

    public function send(ItemInterface $item): void
    {
        // TODO: Implement send() method.
    }
}
