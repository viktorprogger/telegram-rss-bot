<?php

declare(strict_types=1);

namespace rssBot\services;

use rssBot\models\sender\repository\SenderRepositoryInterface;
use rssBot\models\source\SourceInterface;
use rssBot\queue\jobs\SendItemJob;
use rssBot\services\converter\ConverterLocatorInterface;
use Yiisoft\Yii\Queue\Queue;

class Fetcher implements FetcherInterface
{
    private SenderRepositoryInterface $senderRepository;
    private Queue $queue;
    private ConverterLocatorInterface $converterLocator;

    public function __construct(
        Queue $queue,
        SenderRepositoryInterface $senderRepository,
        ConverterLocatorInterface $converterLocator
    ) {
        $this->senderRepository = $senderRepository;
        $this->queue = $queue;
        $this->converterLocator = $converterLocator;
    }

    public function fetch(SourceInterface $source): void
    {
        foreach ($source->getItems() as $item) {
            foreach ($this->senderRepository->getBySource($source) as $sender) {
                if ($sender->suitsSource($item)) {
                    $message = $this->converterLocator->getConverter($sender, $item)->convert($item);
                    if ($sender->suitsMessage($message)) {
                        $this->queue->push(new SendItemJob($message, $sender->getCode()));
                    }
                }
            }
        }
    }
}
