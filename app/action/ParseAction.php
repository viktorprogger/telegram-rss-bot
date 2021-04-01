<?php

declare(strict_types=1);

namespace rssBot\action;

use Evento\Action\ActionInterface;
use Evento\Action\ResultCollection;
use Evento\Action\ResultCollectionInterface;
use rssBot\models\source\repository\SourceRepositoryInterface;

class ParseAction implements ActionInterface
{
    private SourceRepositoryInterface $sourceRepository;

    public function __construct(SourceRepositoryInterface $sourceRepository)
    {
        $this->sourceRepository = $sourceRepository;
    }

    public function run($sourceCode): ResultCollectionInterface
    {
        $items = $this->sourceRepository->get($sourceCode)->getItems();

        return new ResultCollection($items);
    }
}
