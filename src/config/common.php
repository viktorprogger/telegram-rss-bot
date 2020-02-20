<?php

declare(strict_types=1);

use hiqdev\composer\config\Builder;
use rssBot\system\Parameters;
use Spiral\Database\DatabaseInterface;
use Spiral\Database\DatabaseManager;

return [
    DatabaseInterface::class => fn(DatabaseManager $manager) => $manager->database(),
    Parameters::class => [
        '__class' => Parameters::class,
        '__construct()' => require Builder::path('params'),
    ]
];
