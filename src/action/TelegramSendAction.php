<?php

declare(strict_types=1);

namespace rssBot\action;

use rssBot\models\sender\messages\TextMessage;
use rssBot\models\sender\telegram\Sender;
use rssBot\neww\ActionInterface;

class TelegramSendAction implements ActionInterface
{
    private Sender $sender;

    public function __construct(Sender $sender)
    {
        $this->sender = $sender;
    }

    public function run(TextMessage $message = null)
    {
        $this->sender->send($message);
    }
}
