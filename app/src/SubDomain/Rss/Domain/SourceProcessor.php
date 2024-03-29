<?php

declare(strict_types=1);

namespace Resender\SubDomain\Rss\Domain;

use Resender\SubDomain\Rss\Domain\Source\SourceInterface;
use Resender\SubDomain\Rss\Infrastructure\QueueHandler\TargetHandler;
use Yiisoft\Yii\Queue\Message\Message;
use Yiisoft\Yii\Queue\Queue;
use Yiisoft\Yii\Queue\QueueFactory;

final class SourceProcessor
{
    private Queue $queue;

    public function __construct(
        private QueueFactory $queueFactory,
    ) {
        $this->queue = $this->queueFactory->get(TargetHandler::CHANNEL_NAME);
    }

    public function process(SourceInterface $source): void
    {
        foreach ($source->getItems() as $item) {
            $itemArray = [
                'sourceTitle' => $item->getSourceTitle(),
                'title' => $item->getTitle(),
                'description' => $item->getDescription(),
                'updated' => $item->getLastModified()?->format('Y-m-d H:i:s'),
                'link' => $item->getLink(),
            ];

            foreach ($source->getTargetIds() as $id) {
                $data = [
                    'target' => $id->value(),
                    'item' => $itemArray,
                    'sourceId' => $source->getId(),
                ];
                $this->queue->push(new Message(TargetHandler::MESSAGE_NAME, $data));
            }
        }
    }
}
