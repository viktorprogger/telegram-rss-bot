<?php

declare(strict_types=1);

use Psr\Log\LogLevel;

return [
    'yiisoft/log' => [
        'levels' => [
            LogLevel::EMERGENCY,
            LogLevel::ALERT,
            LogLevel::CRITICAL,
            LogLevel::ERROR,
            LogLevel::WARNING,
        ],
    ],
];
