<?php

declare(strict_types=1);

use hiqdev\composer\config\Builder;
use Laminas\Feed\Reader\Reader;
use rssBot\services\http\Client;
use rssBot\system\Parameters;
use Spiral\Database\DatabaseInterface;
use Spiral\Database\DatabaseManager;

return [
    DatabaseInterface::class => fn(DatabaseManager $manager) => $manager->database(),
    Parameters::class => [
        '__class' => Parameters::class,
        '__construct()' => require Builder::path('params'),
    ],
    Reader::class => static function(Client $client) {
        Reader::setHttpClient($client);

        return new Reader();
    },
];
