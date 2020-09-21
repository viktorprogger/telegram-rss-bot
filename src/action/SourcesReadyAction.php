<?php

declare(strict_types=1);

namespace rssBot\action;

use rssBot\neww\ActionInterface;
use rssBot\neww\ResultCollection;

class SourcesReadyAction implements ActionInterface
{
    public function run($sources = null): ResultCollection
    {
        return new ResultCollection($sources);
    }
}
