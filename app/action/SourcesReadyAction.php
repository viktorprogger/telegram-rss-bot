<?php

declare(strict_types=1);

namespace rssBot\action;

use Evento\Action\ActionInterface;
use Evento\Action\ResultCollection;
use Evento\Action\ResultCollectionInterface;

class SourcesReadyAction implements ActionInterface
{
    public function run($sources): ResultCollectionInterface
    {
        return new ResultCollection($sources);
    }
}
