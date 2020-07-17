<?php

declare(strict_types=1);

use FeedIo\Adapter\ClientInterface as FeedClientInterface;
use FeedIo\Adapter\Guzzle\Client as GuzzleFeedClient;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use rssBot\commands\Parse;
use rssBot\models\sender\repository\ParametersRepositoryInterface;
use rssBot\models\sender\repository\SenderRepositoryInterface;
use rssBot\models\source\repository\ParametersRepository;
use rssBot\models\source\repository\SourceRepositoryInterface;
use rssBot\queue\handlers\SourceFetcher;
use rssBot\system\Parameters;
use Yiisoft\Composer\Config\Builder;
use Yiisoft\Factory\Definitions\Reference;
use Yiisoft\Serializer\IgbinarySerializer;
use Yiisoft\Serializer\PhpSerializer;
use Yiisoft\Serializer\SerializerInterface;
use Yiisoft\Yii\Queue\Driver\AMQP\Driver;
use Yiisoft\Yii\Queue\Driver\AMQP\QueueProvider;
use Yiisoft\Yii\Queue\Driver\AMQP\Settings\Exchange;
use Yiisoft\Yii\Queue\Driver\AMQP\Settings\Queue as QueueSettings;
use Yiisoft\Yii\Queue\Queue;

return [
    Parameters::class => [
        '__class' => Parameters::class,
        '__construct()' => [require Builder::path('params')],
    ],
    SourceRepositoryInterface::class => ParametersRepository::class,

    Parse::class => ['__construct()' => [Reference::to('queueFetch')]],
    'queueFetch' => [
        '__class' => Queue::class,
        '__construct()' => [Reference::to('queueDriverFetch')],
    ],
    'queueDriverFetch' => [
        '__class' => Driver::class,
        '__construct()' => [Reference::to('queueProviderFetch')],
    ],
    'queueProviderFetch' => [
        '__class' => QueueProvider::class,
        '__construct()' => [
            'queueSettings' => Reference::to('queueSettingsFetch'),
            'exchangeSettings' => Reference::to('exchangeSettingsFetch'),
        ],
    ],
    'queueSettingsFetch' => [
        '__class' => QueueSettings::class,
        '__construct()' => [
            'queueName' => 'rss-bot-fetch',
            'durable' => true,
        ],
    ],
    'exchangeSettingsFetch' => [
        '__class' => Exchange::class,
        '__construct()' => [
            'exchangeName' => 'rss-bot-fetch',
            'durable' => true,
        ],
    ],

    SourceFetcher::class => ['__construct()' => [Reference::to('queueSend')]],
    'queueSend' => [
        '__class' => Queue::class,
        '__construct()' => [Reference::to('queueDriverSend')],
    ],
    'queueDriverSend' => [
        '__class' => Driver::class,
        '__construct()' => [Reference::to('queueProviderSend')],
    ],
    'queueProviderSend' => [
        '__class' => QueueProvider::class,
        '__construct()' => [
            'queueSettings' => Reference::to('queueSettingsSend'),
            'exchangeSettings' => Reference::to('exchangeSettingsSend'),
        ],
    ],
    'queueSettingsSend' => [
        '__class' => QueueSettings::class,
        '__construct()' => [
            'queueName' => 'rss-bot-send',
            'durable' => true,
        ],
    ],
    'exchangeSettingsSend' => [
        '__class' => Exchange::class,
        '__construct()' => [
            'exchangeName' => 'rss-bot-send',
            'durable' => true,
        ],
    ],

    AbstractConnection::class => [
        '__class' => AMQPStreamConnection::class,
        '__construct()' => [
            'amqp',
            5672,
            'guest',
            'guest'
        ],
    ],
    SerializerInterface::class => PhpSerializer::class,
    LoggerInterface::class => NullLogger::class,
    SenderRepositoryInterface::class => ParametersRepositoryInterface::class,
    FeedClientInterface::class => GuzzleFeedClient::class,
    GuzzleClientInterface::class => GuzzleClient::class,
];
