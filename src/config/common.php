<?php

declare(strict_types=1);

use hiqdev\composer\config\Builder;
use rssBot\models\source\repository\ParametersRepository;
use rssBot\models\source\repository\SourceRepositoryInterface;
use rssBot\queue\handlers\ItemSender;
use rssBot\queue\handlers\SourceFetcher;
use rssBot\queue\messages\SourceFetchJob;
use rssBot\queue\messages\SendItemJob;
use rssBot\system\Parameters;
use Spiral\Database\DatabaseInterface;
use Spiral\Database\DatabaseManager;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Yiisoft\Di\Container;

return [
    DatabaseInterface::class => fn(DatabaseManager $manager) => $manager->database(),
    Parameters::class => [
        '__class' => Parameters::class,
        '__construct()' => require Builder::path('params'),
    ],
    SourceRepositoryInterface::class => ParametersRepository::class,
    MessageBusInterface::class => static function (Container $container) {
        $handlers = [
            SourceFetchJob::class => [$container->get(SourceFetcher::class)],
            SendItemJob::class => [$container->get(ItemSender::class)],
        ];

        return new MessageBus([new HandlersLocator($handlers)]);
    },
];
