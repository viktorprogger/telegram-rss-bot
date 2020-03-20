<?php

declare(strict_types=1);

namespace rssBot\models\sender;

use rssBot\models\sender\converter\ConverterInterface;
use Yiisoft\Validator\DataSetInterface;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\ValidatorInterface;

abstract class AbstractSender implements SenderInterface
{
    /**
     * @var ValidatorInterface[]
     */
    protected array $filters = [];
    protected ConverterInterface $converter;

    public function getConverter(): ConverterInterface
    {
        return $this->converter;
    }

    public function suits(DataSetInterface $message): bool
    {
        foreach ($this->filters as $filter) {
            $results = $filter->validate($message)->getIterator();
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
