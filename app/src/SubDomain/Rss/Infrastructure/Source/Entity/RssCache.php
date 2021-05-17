<?php

declare(strict_types=1);

namespace Resender\SubDomain\Rss\Infrastructure\Source\Entity;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;

#[Entity(role: 'rss_cache', table: 'rss_cache')]
final class RssCache
{
    #[Column(type: 'primary')]
    public ?int $id = null;

    #[Column(type: 'string')]
    public string $hash;

    #[Column(type: 'string')]
    public string $source_id;

    #[Column(type: 'string')]
    public string $target_id;
}
