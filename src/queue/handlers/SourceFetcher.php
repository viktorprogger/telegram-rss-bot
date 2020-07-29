<?php

declare(strict_types=1);

namespace rssBot\queue\handlers;

use rssBot\models\sender\repository\SenderRepositoryInterface;
use rssBot\models\source\repository\SourceRepositoryInterface;
use rssBot\models\source\SourceInterface;
use rssBot\queue\events\FetchEvent;
use rssBot\queue\jobs\SendItemJob;
use Yiisoft\Yii\Queue\MessageInterface as QueueMessageInterface;
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
    /**
     * @var SourceRepositoryInterface
     */
    private SourceRepositoryInterface $sourceRepository;

    public function __construct(
        Queue $queue,
        SenderRepositoryInterface $repository,
        SourceRepositoryInterface $sourceRepository
    )
    {
        $this->repository = $repository;
        $this->queue = $queue;
        $this->sourceRepository = $sourceRepository;
    }

    public function fetch(QueueMessageInterface $message): void
    {
        $source = $this->sourceRepository->get($message['source']);

        foreach ($source->getItems() as $item) {
            foreach ($this->repository->getBySource($source) as $sender) {
                if ($sender->suits($item)) {
                    $dto = $sender->getConverter()->convert($item);
                    $this->queue->push(new SendItemJob($dto));
                }
            }
        }
    }
}
