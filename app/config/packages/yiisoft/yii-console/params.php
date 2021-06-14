<?php

declare(strict_types=1);

use Resender\SubDomain\Rss\Infrastructure\Commands\SourcesCommand;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Infrastructure\Console\GetUpdatesCommand;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Infrastructure\Console\SetTelegramWebhookCommand;
use Yiisoft\Yii\Console\Command\Serve;

return [
    'yiisoft/yii-console' => [
        'id' => 'yii-console',
        'name' => 'Yii Console',
        'autoExit' => false,
        'commands' => [
            'serve' => Serve::class,
            'sources' => SourcesCommand::class,
            'wallet/set-telegram-webhook' => SetTelegramWebhookCommand::class,
            'wallet/get-updates' => GetUpdatesCommand::class,
        ],
        'version' => '3.0',
    ],
];
