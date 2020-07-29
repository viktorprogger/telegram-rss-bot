<?php

declare(strict_types=1);

namespace rssBot\queue\handlers;

use rssBot\models\sender\messages\MessageInterface;
use rssBot\models\sender\repository\SenderRepositoryInterface;
use Yiisoft\Factory\Factory;
use Yiisoft\Yii\Queue\MessageInterface as QueueMessageInterface;

class SourceSender
{
    private SenderRepositoryInterface $repository;
    private Factory $factory;

    public function __construct(SenderRepositoryInterface $repository, Factory $factory)
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    public function send(QueueMessageInterface $message): void
    {
        $sender = $this->repository->getByCode($message->getPayloadData()['sender']);
        $messageDefinition = $this->getMessageDefinition($message);
        $senderItem = $this->factory->create();
    }

    private function getMessageDefinition(QueueMessageInterface $message): MessageInterface
    {
        $configuration = $message->getPayloadData();
        switch ($configuration['class']) {
            
        }
    }
}
