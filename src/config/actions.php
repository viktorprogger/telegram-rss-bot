<?php

declare(strict_types=1);

use rssBot\neww\ActionInterface;
use rssBot\neww\Listener;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\Rules;

return [
    ActionInterface::class => [LogAction::class],
    OpenDoorAction::class => [
        [
            '__class' => Listener::class,
            '__construct()' => [
                'actionDefinition' => TurnTeapotOnAction::class,
                'synchronous' => false,
            ],
        ],
        [
            '__class' => Listener::class,
            '__construct()' => [
                'actionDefinition' => TurnLightOnAction::class,
                'synchronous' => false,
            ],
        ],
    ],
    CheckFingerprintAction => static function() {
        $failResult = (new Result());
        $failResult->addError('Fingerprint not found');

        $rules = [fn(bool $value) => $value ? new Result() : $failResult];

        return new Listener(OpenDoorAction::class, new Rules($rules), false);
    },
];
