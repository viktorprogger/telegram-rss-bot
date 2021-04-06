<?php

declare(strict_types=1);

namespace Resender\Infrastructure\Source\Rss\Entity;

use Cycle\Annotated\Annotation\{Column, Entity};

/**
 * @Entity(table="rss_cache", role="rss_cache")
 */
final class RssCache
{
    /**
     * @Column(type="primary")
     * @var int
     */
    public ?int $id = null;
    /**
     * @Column(type="string")
     * @var string
     */
    public string $hash;
    /**
     * @Column(type="string")
     * @var string
     */
    public string $source_id;
    /**
     * @Column(type="string")
     * @var string
     */
    public string $target_id;
}
