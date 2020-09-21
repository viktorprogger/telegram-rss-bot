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
    CheckFingerprintAction::class => [
        [
            'action' => OpenDoorAction::class,
            'condition' => fn (DoorAccessResult $access) => $access->allowed(),
            'synchronous' => false,
        ],
    ],
];
