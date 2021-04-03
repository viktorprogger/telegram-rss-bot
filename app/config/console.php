<?php

declare(strict_types=1);

use FeedIo\FeedIo;
use GuzzleHttp\Client;
use Resender\Domain\Source\SourceRepositoryInterface;
use Resender\Domain\Target\TargetRepositoryInterface;
use Resender\Infrastructure\Source\Rss\Source;
use Resender\Infrastructure\Source\StaticSourceRepository;
use Resender\Infrastructure\Target\StaticTargetRepository;
use Resender\Infrastructure\Target\StringTargetId;
use Resender\Infrastructure\Target\Telegram\TelegramTarget;

return [
    SourceRepositoryInterface::class => static function (FeedIo $reader) {
        $sources = [
            new Source('https://blog.jetbrains.com/phpstorm/feed/', $reader, new StringTargetId('tg-php-info')),
        ];

        return new StaticSourceRepository(...$sources);
    },

    TargetRepositoryInterface::class => static function(Client $client) {
        $targets = [
            'tg-php-info' => new TelegramTarget(getenv('tg-token'), '', $client), // TODO
        ];

        return new StaticTargetRepository($targets);
    },
];
