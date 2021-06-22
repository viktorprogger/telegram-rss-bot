<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\Action;

use Resender\Domain\Client\Telegram\InlineKeyboardButton;
use Resender\Domain\Client\Telegram\MessageFormat;
use Resender\Domain\Client\Telegram\Response;
use Resender\Domain\Client\Telegram\TelegramMessage;
use Resender\SubDomain\Wallet\Domain\Entity\Wallet\WalletRepositoryInterface;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\TelegramRequest;

final class GetWalletsAction implements ActionInterface
{
    public function __construct(private WalletRepositoryInterface $repository)
    {
    }

    public function handle(TelegramRequest $request, Response $response): Response
    {
        $titles = [];
        $buttons = [];

        $wallets = $this->repository->findByUser($request->getUserId());
        if ($wallets === []) {
            $titles[] = 'Пока нет ни одного кошелька';
        }

        foreach ($wallets as $wallet) {
            $titles[] = $wallet->getTitle();
            $buttons[] = new InlineKeyboardButton($wallet->getTitle(), 'categories:' . $wallet->getId()->value());
        }
        $buttons[] = new InlineKeyboardButton('➕ Создать кошелек ➕', 'wallet-create');

        return $response->withMessage(
            new TelegramMessage(implode("\n", $titles), MessageFormat::text(), $request->getChatId(), $buttons)
        );
    }
}
