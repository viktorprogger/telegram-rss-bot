<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Infrastructure;

use GuzzleHttp\Client;
use Resender\Domain\Client\TelegramClientInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetUpdatesCommand extends Command
{
    public function __construct(private string $token, private TelegramClientInterface $client, string $name = null)
    {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->client->send('getUpdates', $this->token) as $update) {
            // TODO Зарегать незареганного юзверя и обработать его сообщение
        }
    }
}
