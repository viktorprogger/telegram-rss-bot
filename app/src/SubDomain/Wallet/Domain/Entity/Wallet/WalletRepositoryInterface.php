<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Domain\Entity\Wallet;

interface WalletRepositoryInterface
{
    public function create();

    public function update();

    public function remove();

    public function findById();

    public function findByUser();
}
