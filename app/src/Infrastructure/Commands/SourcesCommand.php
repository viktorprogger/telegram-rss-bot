<?php

declare(strict_types=1);

namespace Resender\Infrastructure\Commands;

use Cycle\ORM\ORM;
use Cycle\ORM\Transaction;
use Resender\Domain\Source\SourceRepositoryInterface;
use Resender\Domain\Target\TargetRepositoryInterface;
use Resender\Infrastructure\Source\Github\GithubNotification;
use Resender\Infrastructure\Source\Rss\Entity\RssCache;
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
        private ORM $orm,
        string $name = null,
    ) {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $rssRepository = $this->orm->getRepository(RssCache::class);

        foreach ($this->sourceRepository->getSources() as $source) {
            foreach ($source->getItems() as $item) {
                foreach ($source->getTargetIds() as $id) {
                    switch (get_class($item)) {
                        case RssEntry::class:
                            $filter = [
                                'source_id' => $source->getId(),
                                'target_id' => $id->value(),
                                'hash' => $item->getHash(),
                            ];
                            if ($rssRepository->findOne($filter) === null) {
                                $tr = new Transaction($this->orm);

                                $rssItemCache = new RssCache();
                                $rssItemCache->source_id = $source->getId();
                                $rssItemCache->target_id = $id->value();
                                $rssItemCache->hash = $item->getHash();

                                $this->targetRepository->getById($id)->sendRssItem($item);

                                $tr->persist($rssItemCache);
                                $tr->run();
                            }

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

        return self::SUCCESS;
    }
}
