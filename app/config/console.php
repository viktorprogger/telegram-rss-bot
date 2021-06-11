<?php

declare(strict_types=1);

use Resender\SubDomain\Wallet\Infrastructure\GetUpdatesCommand;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Infrastructure\Console\SetTelegramWebhookCommand;

return [
    SetTelegramWebhookCommand::class => [
        '__construct()' => ['botToken' => getenv('WALLET_BOT_TOKEN')],
    ],
    GetUpdatesCommand::class => [
        '__construct()' => ['token' => getenv('WALLET_BOT_TOKEN')]
    ]
];
