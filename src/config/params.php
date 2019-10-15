<?php
declare(strict_types=1);

use rssBot\dto\FeedItem;

return [
    'bot_token' => getenv('BOT_TOKEN'),
    'rss_channels' => [
        [
            'chat_id' => 'viktorprogger_php_info',
            'links'   => [
                [
                    'title'     => 'JetBrains PhpStorm',
                    'url'       => 'https://blog.jetbrains.com/phpstorm/feed/',
                    'itemClass' => FeedItem::class,
                ],
            ],
        ],
    ],
];
