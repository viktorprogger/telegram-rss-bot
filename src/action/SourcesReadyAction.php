<?php

declare(strict_types=1);

namespace rssBot\action;

use rssBot\models\action\action\ActionInterface;
use rssBot\models\action\action\ResultCollection;

class SourcesReadyAction implements ActionInterface
{
    public function run($sources): ResultCollection
    {
        return new ResultCollection($sources);
    }
}
