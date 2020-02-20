<?php

declare(strict_types=1);

namespace rssBot\commands;

use Cycle\ORM\ORM;
use Cycle\ORM\Select;
use rssBot\orm\Source;
use rssBot\sources\Factory;
use Spiral\Database\Injection\Expression;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @property array source
 */
class Parse extends Command
{
    protected static $defaultName = 'parse';
    private Factory $sourceFactory;
    private ORM $orm;
    private MessageBusInterface $messageBus;

    public function __construct(Factory $factory, ORM $orm, MessageBusInterface $messageBus, string $name = null)
    {
        parent::__construct($name);
        $this->sourceFactory = $factory;
        $this->orm = $orm;
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
        $repository = $this->orm->getRepository(Source::class);
        /** @var Select $query */
        $query = $repository->select();
        $query->where('last_fetched', '<', new Expression('UNIX_TIMESTAMP() - period'));
        if ($codes !== []) {
            $query->andWhere('code', 'in', $codes);
        }

        foreach ($query->fetchAll() as $sourceDefinition) {
            $source = $this->sourceFactory->create($sourceDefinition);
            $this->messageBus->dispatch($source);
        }
    }
}
