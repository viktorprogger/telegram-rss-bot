<?php

declare(strict_types=1);

namespace rssBot\commands;

use rssBot\models\source\repository\SourceRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @property array source
 */
final class Parse extends Command
{
    protected static $defaultName = 'parse';
    private MessageBusInterface $messageBus;
    private SourceRepositoryInterface $repository;

    public function __construct(
        SourceRepositoryInterface $repository,
        MessageBusInterface $messageBus,
        string $name = null
    ) {
        parent::__construct($name);
        $this->repository = $repository;
        $this->messageBus = $messageBus;
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
            $this->messageBus->dispatch($source);
        }
    }
}
