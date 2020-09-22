<?php

declare(strict_types=1);

namespace rssBot\action;

use rssBot\models\action\action\ActionInterface;
use rssBot\models\telegram\Sender;

class TelegramSendAction implements ActionInterface
{
    private Sender $sender;

    public function __construct(Sender $sender)
    {
        $this->sender = $sender;
    }

    public function run($message): void
    {
        $this->sender->send($message);
    }
}
