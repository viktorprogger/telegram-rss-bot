<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain;

use InvalidArgumentException;

final class ChatState
{
    /** @const int Вне кошельков */
    public const OUTSIDE = 1;

    /** @const int Внутри кошелька */
    public const WALLET = 2;

    /** @const int Внутри категории */
    public const CATEGORY = 3;

    /** @const int Создание категории */
    public const CATEGORY_CREATION = 4;

    /** @var self[] */
    private static array $instances = [];

    private function __construct(private int $value)
    {
        $available = [self::OUTSIDE, self::WALLET, self::CATEGORY, self::CATEGORY_CREATION];
        if (!in_array($this->value, $available, true)) {
            throw new InvalidArgumentException('Incorrect chat state');
        }
    }

    public static function getInstance(int $value): self
    {
        if (!isset(self::$instances[$value])) {
            self::$instances[$value] = new self($value);
        }

        return self::$instances[$value];
    }

    public static function outside(): self
    {
        return self::getInstance(self::OUTSIDE);
    }

    public static function wallet(): self
    {
        return self::getInstance(self::WALLET);
    }

    public static function category(): self
    {
        return self::getInstance(self::CATEGORY);
    }

    public static function categoryCreation(): self
    {
        return self::getInstance(self::CATEGORY_CREATION);
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function isOutside(): bool
    {
        return $this->value === self::OUTSIDE;
    }

    public function isWallet(): bool
    {
        return $this->value === self::WALLET;
    }

    public function isCategory(): bool
    {
        return $this->value === self::CATEGORY;
    }

    public function isCategoryCreation(): bool
    {
        return $this->value === self::CATEGORY_CREATION;
    }
}
