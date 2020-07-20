<?php

declare(strict_types=1);

namespace rssBot\queue\events;

use rssBot\models\source\SourceInterface;

class FetchEvent
{
    private SourceInterface $source;

    public function __construct(SourceInterface $source)
    {
        $this->source = $source;
    }

    public function getSource(): SourceInterface
    {
        return $this->source;
    }
}
