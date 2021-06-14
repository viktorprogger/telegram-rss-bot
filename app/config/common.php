<?php

declare(strict_types=1);

use FeedIo\Adapter\ClientInterface as FeedClientInterface;
use FeedIo\Adapter\Guzzle\Client as GuzzleFeedClient;
use FeedIo\FeedIo;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\ClientInterface as GuzzleInterface;
use Ramsey\Uuid\UuidFactory as RamseyFactory;
use Ramsey\Uuid\UuidFactoryInterface;
use Resender\Domain\Client\TelegramClientInterface;
use Resender\Infrastructure\Client\Telegram\TelegramClientGuzzle;
use Resender\SubDomain\Rss\Domain\Source\SourceRepositoryInterface;
use Resender\SubDomain\Rss\Domain\Target\TargetRepositoryInterface;
use Resender\SubDomain\Rss\Infrastructure\SentryInitiator;
use Resender\SubDomain\Rss\Infrastructure\Source\Source;
use Resender\SubDomain\Rss\Infrastructure\Source\StaticSourceRepository;
use Resender\SubDomain\Rss\Infrastructure\Target\StaticTargetRepository;
use Resender\SubDomain\Rss\Infrastructure\Target\StringTargetId;
use Resender\SubDomain\Rss\Infrastructure\Target\Telegram\TelegramTarget;
use Resender\SubDomain\Wallet\Domain\Entity\Category\CategoryIdFactoryInterface;
use Resender\SubDomain\Wallet\Domain\Entity\Category\CategoryRepositoryInterface;
use Resender\SubDomain\Wallet\Domain\Entity\User\UserIdFactoryInterface;
use Resender\SubDomain\Wallet\Domain\Entity\User\UserRepositoryInterface;
use Resender\SubDomain\Wallet\Domain\Entity\Wallet\WalletIdFactoryInterface;
use Resender\SubDomain\Wallet\Domain\Entity\Wallet\WalletRepositoryInterface;
use Resender\SubDomain\Wallet\Infrastructure\Entity\Category\CategoryIdFactory;
use Resender\SubDomain\Wallet\Infrastructure\Entity\Category\CategoryRepository;
use Resender\SubDomain\Wallet\Infrastructure\Entity\User\UserIdFactory;
use Resender\SubDomain\Wallet\Infrastructure\Entity\User\UserRepository;
use Resender\SubDomain\Wallet\Infrastructure\Entity\Wallet\WalletIdFactory;
use Resender\SubDomain\Wallet\Infrastructure\Entity\Wallet\WalletRepository;

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
            'tg-php-info' => new TelegramTarget(
                new StringTargetId('tg-php-info'),
                getenv('RSS_BOT_TOKEN'),
                '@vitorprogger_php_info',
                $client
            ),
        ];

        return new StaticTargetRepository($targets);
    },


    CategoryRepositoryInterface::class => CategoryRepository::class,
    CategoryIdFactoryInterface::class => CategoryIdFactory::class,
    UserRepositoryInterface::class => UserRepository::class,
    UserIdFactoryInterface::class => UserIdFactory::class,
    WalletRepositoryInterface::class => WalletRepository::class,
    WalletIdFactoryInterface::class => WalletIdFactory::class,

    UuidFactoryInterface::class => RamseyFactory::class,
];
