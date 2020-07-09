<?php

declare(strict_types=1);

namespace rssBot\queue\handlers;

use rssBot\queue\messages\SendItemJob;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ItemSender implements MessageHandlerInterface
{
    public function __invoke(SendItemJob $message)
    {
        $message->getSender()->send($message->getItem());
    }
}
