<?php

declare(strict_types=1);

namespace rssBot\commands;

use rssBot\action\SourcesReadyAction ;
use rssBot\models\source\repository\SourceRepositoryInterface;
use rssBot\neww\ActionDispatcher;
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
    private Factory $factory;
    /**
     * @var ActionDispatcher
     */
    private ActionDispatcher $dispatcher;
    /**
     * @var SourcesReadyAction
     */
    private SourcesReadyAction $action;

    public function __construct(
        SourceRepositoryInterface $repository,
        ActionDispatcher $dispatcher,
        SourcesReadyAction $action,
        string $name = null
    ) {
        parent::__construct($name);
        $this->repository = $repository;
        $this->dispatcher = $dispatcher;
        $this->action = $action;
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
        $codes = $this->source ?? iterator_to_array($this->repository->getCodes());
        $this->dispatcher->dispatch($this->action, $this->action->run($codes));

        return 0;
    }
}
