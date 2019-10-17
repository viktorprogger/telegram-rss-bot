<?php
declare(strict_types=1);

use rssBot\dto\StormItem;

return [
    'bot_token' => getenv('BOT_TOKEN'),
    'rss_channels' => [
        [
            'chat_id' => '@vitorprogger_php_info',
            'links'   => [
                [
                    'title'     => 'JetBrains PhpStorm',
                    'url'       => 'https://blog.jetbrains.com/phpstorm/feed/',
                    'itemClass' => StormItem::class,
                ],
                [
                    'title'     => 'JetBrains YouTrack',
                    'url'       => 'https://blog.jetbrains.com/youtrack/feed/',
                    'itemClass' => StormItem::class,
                ],
                [
                    'title'     => 'JetBrains TeamCity',
                    'url'       => 'https://blog.jetbrains.com/teamcity/feed/',
                    'itemClass' => StormItem::class,
                ],
                [
                    'title'     => 'Пятиминутка PHP',
                    'url'       => 'http://feeds.soundcloud.com/users/soundcloud:users:153519653/sounds.rss',
                ],
            ],
        ],
    ],
];
