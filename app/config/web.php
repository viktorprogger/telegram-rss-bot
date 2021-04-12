<?php

declare(strict_types=1);

use HttpSoft\Message\ResponseFactory;
use HttpSoft\Message\ServerRequestFactory;
use HttpSoft\Message\StreamFactory;
use HttpSoft\Message\UploadedFileFactory;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Spiral\RoadRunner\Http\PSR7Worker;
use Spiral\RoadRunner\Http\PSR7WorkerInterface;
use Spiral\RoadRunner\Worker as RRWorker;
use Spiral\RoadRunner\WorkerInterface;
use Yiisoft\Yii\Web\NotFoundHandler;

return [
    PSR7WorkerInterface::class => PSR7Worker::class,
    WorkerInterface::class => static fn() => RRWorker::create(),
    ServerRequestFactoryInterface::class => ServerRequestFactory::class,
    StreamFactoryInterface::class => StreamFactory::class,
    UploadedFileFactoryInterface::class => UploadedFileFactory::class,
    RequestHandlerInterface::class => NotFoundHandler::class,
    ResponseFactoryInterface::class => ResponseFactory::class,
];
