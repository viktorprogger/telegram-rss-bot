<?php

declare(strict_types=1);

namespace rssBot\commands;

use rssBot\models\source\repository\SourceRepositoryInterface;
use rssBot\queue\handlers\SourceFetcher;
use rssBot\queue\messages\SourceFetchJob;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Yiisoft\Yii\Queue\Queue;

/**
 * @property array source
 */
final class Parse extends Command
{
    protected static $defaultName = 'parse';
    private SourceRepositoryInterface $repository;
    private Queue $queue;
    /**
     * @var SourceFetcher
     */
    private SourceFetcher $fetcher;

    public function __construct(
        SourceRepositoryInterface $repository,
        Queue $queue,
        SourceFetcher $fetcher,
        string $name = null
    ) {
        parent::__construct($name);
        $this->repository = $repository;
        $this->queue = $queue;
        $this->fetcher = $fetcher;
    }

    protected function configure(): void
    {
        $this->addOption(
            'source',
            's',
            InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL,
            'Sources to be parsed',
            [],
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $codes = $this->source;

        foreach ($this->repository->get($codes, time()) as $source) {
            $this->queue->push(new SourceFetchJob($source, $this->fetcher));
        }
    }
}
