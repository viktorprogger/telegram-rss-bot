<?php

declare(strict_types=1);

use Spiral\Database\DatabaseInterface;
use Spiral\Database\DatabaseManager;
use yii\queue\file\Queue as FileQueue;
use yii\queue\Queue;

return [
    DatabaseInterface::class => fn(DatabaseManager $manager) => $manager->database(),
    Queue::class => FileQueue::class,
];
