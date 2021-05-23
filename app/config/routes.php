<?php

declare(strict_types=1);

use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Infrastructure\Web\TelegramController;
use Yiisoft\Router\Route;

return [
    Route::post('wallet/telegram-webhook')
        ->action([TelegramController::class, 'webhook'])
        ->name('wallet/telegram-webhook'),
];
