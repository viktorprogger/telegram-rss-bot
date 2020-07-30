<?php

declare(strict_types=1);

namespace rssBot\queue\handlers;

use rssBot\models\source\repository\SourceRepositoryInterface;
use rssBot\services\FetcherInterface;
use Yiisoft\Yii\Queue\MessageInterface as QueueMessageInterface;

final class SourceHandler
{
    private SourceRepositoryInterface $sourceRepository;
    private FetcherInterface $fetcher;

    public function __construct(SourceRepositoryInterface $sourceRepository, FetcherInterface $fetcher)
    {
        $this->sourceRepository = $sourceRepository;
        $this->fetcher = $fetcher;
    }

    public function handle(QueueMessageInterface $message): void
    {
        $source = $this->sourceRepository->get($message->getPayloadData()['source']);
        $this->fetcher->fetch($source);
    }
}
