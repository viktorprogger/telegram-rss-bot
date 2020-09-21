<?php

declare(strict_types=1);

namespace rssBot\action;

use rssBot\models\source\repository\SourceRepositoryInterface;
use rssBot\neww\ActionInterface;
use rssBot\neww\ResultCollection;

class ParseAction implements ActionInterface
{
    private SourceRepositoryInterface $sourceRepository;

    public function __construct(SourceRepositoryInterface $sourceRepository)
    {
        $this->sourceRepository = $sourceRepository;
    }

    public function run($sourceCode = null)
    {
        $items = $this->sourceRepository->get($sourceCode)->getItems();

        return new ResultCollection($items);
    }
}
