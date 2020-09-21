<?php

declare(strict_types=1);

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
use rssBot\models\sender\repository\ParametersRepositoryInterface;
use rssBot\models\sender\repository\SenderRepositoryInterface;
use rssBot\models\sender\telegram\Sender;
use rssBot\models\source\repository\ParametersRepository;
use rssBot\models\source\repository\SourceRepositoryInterface;
use rssBot\neww\ActionFactory;
use rssBot\neww\ActionFactoryInterface;
use rssBot\neww\ActionListenerProvider;
use rssBot\neww\ActionListenerProviderInterface;
use rssBot\system\Parameters;
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
    Parameters::class => [
        '__class' => Parameters::class,
        '__construct()' => [require Builder::path('params')],
    ],
    SourceRepositoryInterface::class => ParametersRepository::class,
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
    Logger::class => static function () {
        $handlers = [
            new StreamHandler(dirname(__DIR__) . '/runtime/application.log', Logger::WARNING, false),
            new StreamHandler(dirname(__DIR__) . '/runtime/debug.log', Logger::DEBUG),
        ];
        $processors = [
            new PsrLogMessageProcessor(),
        ];

        return new Logger('application', $handlers, $processors);
    },
    SenderRepositoryInterface::class => ParametersRepositoryInterface::class,
    FeedClientInterface::class => GuzzleFeedClient::class,
    GuzzleClientInterface::class => GuzzleClient::class,
    Factory::class => static fn(ContainerInterface $container) => new Factory($container),
    Sender::class => [
        '__class' => Sender::class,
        '__construct()' => [getenv('BOT_TOKEN'), getenv('CHAT_ID')],
    ],
    ActionListenerProviderInterface::class => ActionListenerProvider::class,
    ActionListenerProvider::class => [
        '__class' => ActionListenerProvider::class,
        '__construct()' => [Builder::require('actions')],
    ],
    ActionFactoryInterface::class => ActionFactory::class,
];
