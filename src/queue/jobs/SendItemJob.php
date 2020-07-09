<?php

declare(strict_types=1);

namespace rssBot\queue\jobs;

use rssBot\models\sender\messages\MessageInterface;
use rssBot\models\sender\SenderInterface;
use Yiisoft\Yii\Queue\Job\JobInterface;

class SendItemJob implements JobInterface
{
    private MessageInterface $item;
    private SenderInterface $sender;

    public function __construct(MessageInterface $item, SenderInterface $sender)
    {
        $this->item = $item;
        $this->sender = $sender;
    }

    public function execute(): void
    {
        $this->sender->send($this->item);
    }
}
