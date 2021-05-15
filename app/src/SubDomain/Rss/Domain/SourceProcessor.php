<?php

declare(strict_types=1);

namespace Resender\SubDomain\Rss\Domain;

use Cycle\ORM\ORM;
use Cycle\ORM\Transaction;
use Resender\SubDomain\Rss\Domain\Source\SourceInterface;
use Resender\SubDomain\Rss\Domain\Target\TargetRepositoryInterface;
use Resender\SubDomain\Rss\Infrastructure\QueueHandler\TargetHandler;
use Resender\SubDomain\Rss\Infrastructure\Source\Entity\RssCache;
use Yiisoft\Yii\Queue\Message\Message;
use Yiisoft\Yii\Queue\QueueFactory;

final class SourceProcessor
{
    public function __construct(
        private QueueFactory $queueFactory,
    ) {
    }

    public function process(SourceInterface $source): void
    {
        $queue = $this->queueFactory->get(TargetHandler::CHANNEL_NAME);

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
                    'target' => $id,
                    'item' => $itemArray,
                    'sourceId' => $source->getId(),
                ];
                $queue->push(new Message(TargetHandler::MESSAGE_NAME, $data));
            }
        }
    }
}
