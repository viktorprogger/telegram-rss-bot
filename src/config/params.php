<?php
declare(strict_types=1);

return [
    'bot_token' => getenv('BOT_TOKEN'),
    'rss_channels' => require __DIR__ . '/channels.php',
];
