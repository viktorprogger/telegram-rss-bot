<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\Action;

use Resender\Domain\Client\Telegram\InlineKeyboardButton;
use Resender\Domain\Client\Telegram\MessageFormat;
use Resender\Domain\Client\Telegram\TelegramMessage;
use Resender\SubDomain\Wallet\Domain\Entity\Category\CategoryRepositoryInterface;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\TelegramRequest;

class ShowCategoriesAction implements ActionInterface
{
    public function __construct(private CategoryRepositoryInterface $repository)
    {
    }

    public function handle(TelegramRequest $request): TelegramMessage
    {
        $categories = $this->repository->findByWallet($request->getWalletId());
        $titles = [];
        $buttons = [];

        if ($categories === []) {
            $titles[] = 'В кошельке пока нет категорий. Создать новую?';
        } else {
            foreach ($categories as $category) {
                $titles[] = $category->getTitle();
                $buttons[] = new InlineKeyboardButton($category->getTitle(), 'category:' . $category->getId()->value());
            }
        }

        $buttons[] = new InlineKeyboardButton('➕ Создать категорию ➕', 'category-create:' . $request->getWalletId()->value());

        return new TelegramMessage(implode("\n", $titles), MessageFormat::text(), $buttons);
    }
}
