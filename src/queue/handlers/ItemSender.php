<?php

declare(strict_types=1);

namespace rssBot\queue\handlers;

use rssBot\queue\messages\SourceItemMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ItemSender implements MessageHandlerInterface
{
    public function __invoke(SourceItemMessage $message)
    {
        $message->getSender()->send($message->getItem());
    }
}
