<?php

declare(strict_types=1);

namespace rssBot\queue\jobs;

use rssBot\models\source\ItemInterface;
use Yiisoft\Yii\Queue\Payload\PayloadInterface;

class SendItemJob implements PayloadInterface
{
    public const NAME = 'resender-bot/message-send';

    private ItemInterface $message;
    private string $sender;

    public function __construct(ItemInterface $message, string $sender)
    {
        $this->message = $message;
        $this->sender = $sender;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getData(): array
    {
        return [
            'sender' => $this->sender,
            'item' => [
                '_class' => get_class($this->message),
                '__construct()' => $this->message,
            ],
        ];
    }

    public function getMeta(): array
    {
        return [];
    }
}
