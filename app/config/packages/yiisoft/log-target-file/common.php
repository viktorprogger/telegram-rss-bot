<?php

declare(strict_types=1);

use Psr\Log\LoggerInterface;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Log\Logger;
use Yiisoft\Log\StreamTarget;
use Yiisoft\Log\Target\File\FileRotator;
use Yiisoft\Log\Target\File\FileRotatorInterface;
use Yiisoft\Log\Target\File\FileTarget;

/* @var $params array */

return [
    StreamTarget::class => static fn() => (new StreamTarget())
        ->setExportInterval(1)
        ->setLevels($params['yiisoft/log']['levels']),
    LoggerInterface::class => static fn (StreamTarget $streamTarget, FileTarget $fileTarget) => (new Logger([$streamTarget, $fileTarget]))->setFlushInterval(1),

    FileRotatorInterface::class => [
        'class' => FileRotator::class,
        '__construct()' => [
            $params['yiisoft/log-target-file']['fileRotator']['maxFileSize'],
            $params['yiisoft/log-target-file']['fileRotator']['maxFiles'],
            $params['yiisoft/log-target-file']['fileRotator']['fileMode'],
            $params['yiisoft/log-target-file']['fileRotator']['rotateByCopy'],
            $params['yiisoft/log-target-file']['fileRotator']['compressRotatedFiles'],
        ],
    ],

    FileTarget::class => static function (Aliases $aliases, FileRotatorInterface $fileRotator) use ($params) {
        $fileTarget = new FileTarget(
            $aliases->get($params['yiisoft/log-target-file']['fileTarget']['file']),
            $fileRotator,
            $params['yiisoft/log-target-file']['fileTarget']['dirMode'],
            $params['yiisoft/log-target-file']['fileTarget']['fileMode'],
        );

        $fileTarget->setLevels($params['yiisoft/log']['levels']);

        return $fileTarget;
    },
];
