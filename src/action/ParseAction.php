<?php

declare(strict_types=1);

namespace rssBot\action;

use rssBot\models\action\action\ActionInterface;
use rssBot\models\action\action\ResultCollection;
use rssBot\models\source\repository\SourceRepositoryInterface;

class ParseAction implements ActionInterface
{
    private SourceRepositoryInterface $sourceRepository;

    public function __construct(SourceRepositoryInterface $sourceRepository)
    {
        $this->sourceRepository = $sourceRepository;
    }

    public function run($sourceCode)
    {
        $items = $this->sourceRepository->get($sourceCode)->getItems();

        return new ResultCollection(iterator_to_array($items));
    }
}
