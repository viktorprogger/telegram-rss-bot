<?php

declare(strict_types=1);

use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Connection\AMQPLazySocketConnection;
use Yiisoft\Yii\Queue\Adapter\AdapterInterface;
use Yiisoft\Yii\Queue\AMQP\Adapter;
use Yiisoft\Yii\Queue\AMQP\MessageSerializer;
use Yiisoft\Yii\Queue\AMQP\MessageSerializerInterface;
use Yiisoft\Yii\Queue\AMQP\QueueProvider;
use Yiisoft\Yii\Queue\AMQP\QueueProviderInterface;
use Yiisoft\Yii\Queue\AMQP\Settings\Queue;
use Yiisoft\Yii\Queue\AMQP\Settings\QueueSettingsInterface;

return [
    MessageSerializerInterface::class => MessageSerializer::class,
    QueueProviderInterface::class => QueueProvider::class,
    QueueSettingsInterface::class => [
        'class' => Queue::class,
        '__construct()' => ['queueName' => 'yii-queue'],
    ],
    AdapterInterface::class => Adapter::class,
    AbstractConnection::class => AMQPLazySocketConnection::class,
    AMQPLazySocketConnection::class => [
        '__construct()' => [
            'host' => 'amqp',
            'port' => 5672,
            'user' => getenv('AMQP_USER'),
            'password' => getenv('AMQP_PASSWORD'),
        ],
    ],
];
