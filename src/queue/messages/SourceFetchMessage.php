<?php

declare(strict_types=1);

namespace rssBot\queue\messages;

use rssBot\models\source\SourceInterface;

class SourceFetchMessage
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
