<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Infrastructure\Console;

use Resender\Domain\Client\TelegramClientInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SetTelegramWebhookCommand extends Command
{
    public function __construct(private TelegramClientInterface $client, private string $botToken, string $name = null)
    {
        parent::__construct($name);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $fields = [
            'url' => 'https://wallet.viktorprogger.com/wallet/telegram-webhook',
            'allowed_updates' => ['message'],
        ];

        $this->client->send('setWebhook', $this->botToken, $fields);
    }
}
