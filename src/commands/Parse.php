<?php

declare(strict_types=1);

namespace rssBot\commands;

use rssBot\models\source\repository\SourceRepositoryInterface;
use rssBot\queue\handlers\SourceHandler;
use rssBot\queue\jobs\SourceFetchJob;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Yiisoft\Factory\Factory;
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
     * @var Factory
     */
    private Factory $factory;

    public function __construct(
        Queue $queue,
        SourceRepositoryInterface $repository,
        Factory $factory,
        string $name = null
    ) {
        parent::__construct($name);
        $this->repository = $repository;
        $this->queue = $queue;
        $this->factory = $factory;
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

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        error_reporting (E_ALL ^ E_NOTICE);
        $codes = $this->source ?? $this->repository->getCodes();

        foreach ($codes as $code) {
            $job = new SourceFetchJob($code);
            $this->queue->push($job);
        }

        return 0;
    }
}
