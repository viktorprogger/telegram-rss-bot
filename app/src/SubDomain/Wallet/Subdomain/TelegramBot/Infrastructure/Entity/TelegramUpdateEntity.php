<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Infrastructure\Entity;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use DateTimeImmutable;

#[Entity(table: 'wl_tg_update')]
final class TelegramUpdateEntity
{
    #[Column(type: 'int', primary: true)]
    public int $id;

    #[Column(type: 'timestamp')]
    public DateTimeImmutable $created_at;

    #[Column(type: 'longText')]
    public string $contents;
}
