<?php

declare(strict_types=1);

namespace Resender\Infrastructure\Commands;

use Resender\Domain\Source\SourceRepositoryInterface;
use Resender\Domain\Target\TargetRepositoryInterface;
use Resender\Infrastructure\Source\Github\GithubNotification;
use Resender\Infrastructure\Source\Rss\RssEntry;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SourcesCommand extends Command
{
    public function __construct(
        private SourceRepositoryInterface $sourceRepository,
        private TargetRepositoryInterface $targetRepository,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->sourceRepository->getSources() as $source) {
            foreach ($source->getItems() as $item) {
                foreach ($source->getTargetIds() as $id) {
                    switch (get_class($item)) {
                        case RssEntry::class:
                            $this->targetRepository->getById($id)->sendRssItem($item);
                            break;
                        case GithubNotification::class:
                            $this->targetRepository->getById($id)->sendGithubNotification($item);
                            break;
                        default:
                            throw new RuntimeException('Unsupported item type');
                    }
                }
            }
        }
    }
}
