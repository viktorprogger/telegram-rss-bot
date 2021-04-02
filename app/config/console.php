<?php

declare(strict_types=1);

use Resender\Domain\Source\SourceRepositoryInterface;
use Resender\Infrastructure\Source\Rss\Source;
use Resender\Infrastructure\Source\StaticSourceRepository;

return [
    SourceRepositoryInterface::class => [
        '__class' => StaticSourceRepository::class,
        '__construct()' => [
            [
                new Source($url, $reader, $targets)
            ]
        ],
    ],
];
