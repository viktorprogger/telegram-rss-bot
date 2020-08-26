<?php

declare(strict_types=1);

namespace rssBot\queue\handlers;

use rssBot\models\sender\repository\SenderRepositoryInterface;
use rssBot\services\converter\ConverterLocatorInterface;
use Yiisoft\Factory\Factory;
use Yiisoft\Yii\Queue\MessageInterface as QueueMessageInterface;

final class MessageHandler
{
    private SenderRepositoryInterface $repository;
    private Factory $factory;
    private ConverterLocatorInterface $converterLocator;

    public function __construct(SenderRepositoryInterface $repository, Factory $factory)
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    public function handle(QueueMessageInterface $message): void
    {
        $sender = $this->repository->getByCode($message->getPayloadData()['sender']);
        $itemData = $message->getPayloadData()['item'];
        $itemConfig = [
            '__class' => $itemData['class'],
            '__construct()' => $itemData,
        ];
        unset($itemConfig['__construct()']['class']);
        $senderItem = $this->factory->create($itemConfig);
        $sender->send($senderItem);
    }
}
