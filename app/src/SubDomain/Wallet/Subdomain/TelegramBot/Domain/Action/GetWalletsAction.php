<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\Action;

use Resender\Domain\Client\Telegram\InlineKeyboardButton;
use Resender\Domain\Client\Telegram\MessageFormat;
use Resender\Domain\Client\Telegram\TelegramMessage;
use Resender\SubDomain\Wallet\Domain\Entity\Wallet\WalletRepositoryInterface;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\TelegramRequest;

final class GetWalletsAction implements ActionInterface
{
    public function __construct(private WalletRepositoryInterface $repository)
    {
    }

    public function handle(TelegramRequest $request): TelegramMessage
    {
        $wallets = $this->repository->findByUser($request->getUserId());
        if ($wallets === []) {
            return new TelegramMessage('Пока нет ни одного кошелька', MessageFormat::text());
        }

        $titles = [];
        $buttons = [];
        foreach ($wallets as $wallet) {
            $titles[] = $wallet->getTitle();
            $buttons[] = new InlineKeyboardButton($wallet->getTitle(), 'categories:' . $wallet->getId()->value());
        }

        return new TelegramMessage(implode("\n", $titles), MessageFormat::text(), $buttons);
    }
}
