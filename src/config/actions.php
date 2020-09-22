<?php

declare(strict_types=1);

use rssBot\action\ConvertRssMarkdownAction;
use rssBot\action\ParseAction;
use rssBot\action\SourcesReadyAction;
use rssBot\action\TelegramSendAction;

return [
    SourcesReadyAction::class => [
        [
            'action' => ParseAction::class,
            'synchronous' => true,
        ],
    ],
    ParseAction::class => [
        [
            'action' => ConvertRssMarkdownAction::class,
        ],
    ],
    ConvertRssMarkdownAction::class => [
        [
            'action' => TelegramSendAction::class,
            'synchronous' => true,
        ],
    ],

    // ActionInterface::class => [LogAction::class],
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
