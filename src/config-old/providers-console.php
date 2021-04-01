<?php

declare(strict_types=1);

use Psr\Log\LoggerInterface;
use Yiisoft\Di\Container;
use Yiisoft\Di\Support\ServiceProvider;

return [
    new class extends ServiceProvider {
        private LoggerInterface $logger;

        public function __construct(LoggerInterface $logger)
        {
            $this->logger = $logger;
        }

        public function register(Container $container): void
        {
            set_exception_handler([$this->logger, 'error']);
        }
    },
];
