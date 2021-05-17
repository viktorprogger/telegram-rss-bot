<?php

declare(strict_types=1);

namespace Resender\SubDomain\Rss\Infrastructure\QueueHandler;

use Psr\Log\LoggerInterface;
use Resender\SubDomain\Rss\Domain\Source\SourceRepositoryInterface;
use Resender\SubDomain\Rss\Domain\SourceProcessor;
use Yiisoft\Yii\Queue\Message\MessageInterface;

final class SourceHandler
{
    public const CHANNEL_NAME = 'rss-source';
    public const MESSAGE_NAME = 'rss-source';

    public function __construct(
        private SourceProcessor $sourceProcessor,
        private SourceRepositoryInterface $repository,
        private LoggerInterface $logger,
    ) {
    }

    public function handle(MessageInterface $message): void
    {
        $this->logger->info('Processing a source', ['source' => $message->getData()]);
        $this->sourceProcessor->process($this->repository->getById($message->getData()));
    }
}
