<?php

declare(strict_types=1);

namespace rssBot\queue\handlers;

use rssBot\models\sender\repository\SenderRepositoryInterface;
use Yiisoft\Factory\Factory;
use Yiisoft\Yii\Queue\MessageInterface as QueueMessageInterface;

final class MessageHandler
{
    private SenderRepositoryInterface $repository;
    private Factory $factory;

    public function __construct(SenderRepositoryInterface $repository, Factory $factory)
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    public function handle(QueueMessageInterface $message): void
    {
        $sender = $this->repository->getByCode($message->getPayloadData()['sender']);
        $senderItem = $this->factory->create($message->getPayloadData()['item']);
        $dto = $sender->getConverter()->convert($senderItem);
        $sender->send($dto);
    }
}
