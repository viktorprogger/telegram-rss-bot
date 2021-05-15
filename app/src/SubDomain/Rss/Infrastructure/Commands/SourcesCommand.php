<?php

declare(strict_types=1);

namespace Resender\SubDomain\Rss\Infrastructure\Commands;

use Psr\Log\LoggerInterface;
use Resender\SubDomain\Rss\Domain\Source\SourceRepositoryInterface;
use Resender\SubDomain\Rss\Infrastructure\QueueHandler\SourceHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Yiisoft\Yii\Queue\Message\Message;
use Yiisoft\Yii\Queue\QueueFactory;

final class SourcesCommand extends Command
{
    public function __construct(
        private SourceRepositoryInterface $sourceRepository,
        private QueueFactory $queueFactory,
        private LoggerInterface $logger,
        string $name = null,
    ) {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $queue = $this->queueFactory->get(SourceHandler::CHANNEL_NAME);
        foreach ($this->sourceRepository->getSources() as $source) {
            $this->logger->info('Pushing a source to the queue', ['source' => $source->getId()]);
            $queue->push(new Message(SourceHandler::MESSAGE_NAME, $source->getId()));
        }

        return self::SUCCESS;
    }
}
