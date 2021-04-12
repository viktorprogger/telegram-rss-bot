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
];
