<?php

declare(strict_types=1);

namespace rssBot\queue\jobs;

use rssBot\models\sender\messages\MessageInterface;
use rssBot\models\sender\SenderInterface;
use Yiisoft\Yii\Queue\Payload\PayloadInterface;

class SendItemJob implements PayloadInterface
{
    private MessageInterface $message;
    private SenderInterface $sender;
    public const NAME = 'resender-bot/message-send';

    public function __construct(MessageInterface $message)
    {
        $this->message = $message;
    }

    public function execute(): void
    {
        $this->sender->send($this->message);
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getData(): string
    {
        return json_encode($this->message, JSON_THROW_ON_ERROR);
    }

    public function getMeta(): array
    {
        return [];
    }
}
