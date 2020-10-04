<?php

declare(strict_types=1);

use Evento\Dispatcher\Handler\HandlerFactory;
use FeedIo\Adapter\ClientInterface as FeedClientInterface;
use FeedIo\Adapter\Guzzle\Client as GuzzleFeedClient;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\PsrLogMessageProcessor;
use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use rssBot\models\source\repository\ParametersRepository;
use rssBot\models\source\repository\SourceRepositoryInterface;
use rssBot\models\telegram\Sender;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Cache\Cache;
use Yiisoft\Cache\CacheInterface as YiiCacheInterface;
use Yiisoft\Cache\File\FileCache;
use Yiisoft\Composer\Config\Builder;
use Yiisoft\Factory\Factory;
use Yiisoft\Serializer\PhpSerializer;
use Yiisoft\Serializer\SerializerInterface;
use Yiisoft\Yii\Event\EventDispatcherProvider;
use Yiisoft\Yii\Queue\AMQP\Driver;
use Yiisoft\Yii\Queue\AMQP\QueueProvider;
use Yiisoft\Yii\Queue\AMQP\QueueProviderInterface;
use Yiisoft\Yii\Queue\AMQP\Settings\Exchange;
use Yiisoft\Yii\Queue\AMQP\Settings\ExchangeSettingsInterface;
use Yiisoft\Yii\Queue\AMQP\Settings\Queue as QueueSettings;
use Yiisoft\Yii\Queue\Driver\DriverInterface;

/**
 * @var array $params
 */

return [
    SourceRepositoryInterface::class => ParametersRepository::class,
    ParametersRepository::class => ['__construct()' => [$params['sources']]],

    EventDispatcherProvider::class => [
        '__class' => EventDispatcherProvider::class,
        '__construct()' => [Builder::require('events-console')],
    ],

    DriverInterface::class => Driver::class,
    QueueProviderInterface::class => QueueProvider::class,
    AbstractConnection::class => [
        '__class' => AMQPStreamConnection::class,
        '__construct()' => [
            'amqp',
            5672,
            'guest',
            'guest',
        ],
    ],
    QueueSettings::class => [
        '__class' => QueueSettings::class,
        '__construct()' => [
            'queueName' => 'actions',
            'durable' => true,
        ],
    ],
    ExchangeSettingsInterface::class => Exchange::class,
    Exchange::class => [
        '__class' => Exchange::class,
        '__construct()' => [
            'exchangeName' => 'actions',
            'durable' => true,
        ],
    ],

    SerializerInterface::class => PhpSerializer::class,
    LoggerInterface::class => Logger::class,
    Logger::class => static function (): Logger {
        $handlers = [
            new StreamHandler(dirname(__DIR__) . '/runtime/application.log', Logger::WARNING, false),
            new StreamHandler(dirname(__DIR__) . '/runtime/debug.log', Logger::DEBUG),
        ];
        $processors = [
            new PsrLogMessageProcessor(),
        ];

        return new Logger('application', $handlers, $processors);
    },
    FeedClientInterface::class => GuzzleFeedClient::class,
    GuzzleClientInterface::class => GuzzleClient::class,
    Factory::class => static fn(ContainerInterface $container): Factory => new Factory($container),
    Sender::class => [
        '__class' => Sender::class,
        '__construct()' => [getenv('BOT_TOKEN'), getenv('CHAT_ID')],
    ],

    Aliases::class => ['__construct()' => [$params['yiisoft/aliases']]],
    CacheInterface::class => FileCache::class,
    YiiCacheInterface::class => Cache::class,
    FileCache::class => static fn (Aliases $aliases, SerializerInterface $serializer) => new FileCache($aliases->get('@runtime/cache'), $serializer),

    HandlerFactory::class => [
        'withDeferredDefault()' => [true],
    ],
];
