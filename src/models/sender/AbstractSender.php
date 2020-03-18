<?php

declare(strict_types=1);

namespace rssBot\models\sender;

use rssBot\models\source\ItemInterface;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\ValidatorInterface;

abstract class AbstractSender implements SenderInterface
{
    /**
     * @var ValidatorInterface[]
     */
    protected array $filters = [];

    public function suits(ItemInterface $item) : bool{
        foreach ($this->filters as $filter) {
            $results = $filter->validate($item)->getIterator();
            /** @var Result $result */
            foreach ($results as $result) {
                if ($result->getErrors() !== []) {
                    return false;
                }
            }
        }

        return true;
    }

    public function addFilter(ValidatorInterface ...$filters): void
    {
        $this->filters = array_merge($this->filters, $filters);
    }
}
