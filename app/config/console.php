<?php

declare(strict_types=1);

use FeedIo\Adapter\ClientInterface as FeedClientInterface;
use FeedIo\Adapter\Guzzle\Client as GuzzleFeedClient;
use FeedIo\FeedIo;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\ClientInterface as GuzzleInterface;
use Resender\Domain\Source\SourceRepositoryInterface;
use Resender\Domain\Target\TargetRepositoryInterface;
use Resender\Infrastructure\SentryInitiator;
use Resender\Infrastructure\Source\Rss\Source;
use Resender\Infrastructure\Source\StaticSourceRepository;
use Resender\Infrastructure\Target\StaticTargetRepository;
use Resender\Infrastructure\Target\StringTargetId;
use Resender\Infrastructure\Target\Telegram\TelegramClientGuzzle;
use Resender\Infrastructure\Target\Telegram\TelegramClientInterface;
use Resender\Infrastructure\Target\Telegram\TelegramTarget;

return [
    FeedClientInterface::class => GuzzleFeedClient::class,
    GuzzleInterface::class => Guzzle::class,
    TelegramClientInterface::class => TelegramClientGuzzle::class,
    SentryInitiator::class => [
        '__construct()' => ['https://b6a226cfb9b94b928832bcd27d24f9b1@o566448.ingest.sentry.io/5709307'],
    ],

    SourceRepositoryInterface::class => static function (FeedIo $reader) {
        $tgPhpinfo = new StringTargetId('tg-php-info');
        $sources = [
            new Source('Space', 'https://blog.jetbrains.com/space/feed/', $reader, $tgPhpinfo),
            new Source('PhpStorm', 'https://blog.jetbrains.com/phpstorm/feed/', $reader, $tgPhpinfo),
            new Source('YouTrack', 'https://blog.jetbrains.com/youtrack/feed/', $reader, $tgPhpinfo),
            new Source('Habr SamDark', 'https://habr.com/ru/users/SamDark/rss/posts/?fl=ru', $reader, $tgPhpinfo),
        ];

        return new StaticSourceRepository(...$sources);
    },

    TargetRepositoryInterface::class => static function (TelegramClientInterface $client) {
        $targets = [
            'tg-php-info' => new TelegramTarget(getenv('RSS_BOT_TOKEN'), '@vitorprogger_php_info', $client),
        ];

        return new StaticTargetRepository($targets);
    },
];
