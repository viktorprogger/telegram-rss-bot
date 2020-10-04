<?php

declare(strict_types=1);

namespace rssBot\commands;

use Evento\Dispatcher\ActionDispatcherInterface;
use rssBot\action\SourcesReadyAction;
use rssBot\models\source\repository\SourceRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @property array source
 */
final class Parse extends Command
{
    protected static $defaultName = 'parse';
    private SourceRepositoryInterface $repository;
    private ActionDispatcherInterface $dispatcher;
    private SourcesReadyAction $action;

    public function __construct(
        SourceRepositoryInterface $repository,
        ActionDispatcherInterface $dispatcher,
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
        $codes = $this->source ?? $this->repository->getCodes();
        $this->dispatcher->dispatch($this->action, $this->action->run($codes));

        return 0;
    }
}
