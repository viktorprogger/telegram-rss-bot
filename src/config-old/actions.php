<?php

declare(strict_types=1);

use rssBot\action\ConvertRssMarkdownAction;
use rssBot\action\ParseAction;
use rssBot\action\SourcesReadyAction;
use rssBot\action\TelegramSendAction;

return [
    SourcesReadyAction::class => [
        ParseAction::class,
    ],
    ParseAction::class => [
        ConvertRssMarkdownAction::class,
    ],
    ConvertRssMarkdownAction::class => [
        TelegramSendAction::class,
    ],
];
