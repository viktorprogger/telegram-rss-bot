<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\Action;

use Resender\Domain\Client\Telegram\TelegramMessage;
use Resender\SubDomain\Wallet\Domain\Entity\Wallet\WalletCreationData;
use Resender\SubDomain\Wallet\Domain\Entity\Wallet\WalletIdFactoryInterface;
use Resender\SubDomain\Wallet\Domain\Entity\Wallet\WalletRepositoryInterface;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\TelegramRequest;

class CreateWalletAction implements ActionInterface
{
    public function __construct(
        private WalletRepositoryInterface $repository,
        private WalletIdFactoryInterface $idFactory,
        private GetWalletsAction $getWalletsAction,
    ) {
    }

    public function handle(TelegramRequest $request): TelegramMessage
    {
        $walletData = new WalletCreationData(
            $this->idFactory->create(),
            $request->getUserId(),
            true,
            $request->getData()
        );

        $this->repository->create($walletData);

        // TODO хрень хренью. Надо отделить экшены от формирования сообщений
        return $this->getWalletsAction->handle($request);
    }
}
