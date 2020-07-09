<?php

declare(strict_types=1);

namespace rssBot\queue\handlers;

use rssBot\models\sender\repository\SenderRepositoryInterface;
use rssBot\models\source\SourceInterface;
use rssBot\queue\messages\SendItemJob;
use Yiisoft\Yii\Queue\Queue;

class SourceFetcher
{
    /**
     * @var SenderRepositoryInterface
     */
    private SenderRepositoryInterface $repository;
    /**
     * @var Queue
     */
    private Queue $queue;

    public function __construct(Queue $queue, SenderRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->queue = $queue;
    }

    public function fetch(SourceInterface $source): void
    {
        foreach ($source->getItems() as $item) {
            foreach ($this->repository->getBySource($source) as $sender) {
                if ($sender->suits($item)) {
                    $dto = $sender->getConverter()->convert($item);
                    $this->queue->push(new SendItemJob($dto, $sender));
                }
            }
        }
    }
}
