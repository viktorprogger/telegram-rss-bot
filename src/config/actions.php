<?php

declare(strict_types=1);

use rssBot\neww\ActionInterface;

return [
    ActionInterface::class => [LogAction::class],
    OpenDoorAction::class => [
        [
            'action' => TurnTeapotOnAction::class,
            'synchronous' => false,
        ],
        [
            'action' => TurnLightOnAction::class,
            'synchronous' => false,
        ],
    ],
    CheckFingerprintAction => [
        'action' => OpenDoorAction::class,
        'condition' => fn(bool $value) => $value,
        'synchronous' => false,
    ],
];
