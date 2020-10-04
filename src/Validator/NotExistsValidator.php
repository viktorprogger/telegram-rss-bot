<?php

declare(strict_types=1);

namespace rssBot\Validator;

use Cycle\ORM\ORM;
use InvalidArgumentException;
use rssBot\Entity\RssCache;
use rssBot\models\source\HashAwareInterface;
use Yiisoft\Validator\DataSetInterface;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\Rule;

final class NotExistsValidator extends Rule
{
    private ORM $orm;
    private string $destination;

    public function __construct(string $destination, ORM $orm)
    {
        $this->destination = $destination;
        $this->orm = $orm;
    }

    /**
     * @inheritDoc
     */
    protected function validateValue($value, DataSetInterface $dataSet = null): Result
    {
        if (!$value instanceof HashAwareInterface || $value->getHash() !== '') {
            throw new InvalidArgumentException('The given value must be an instance of HashAwareInterface and have a valid hash');
        }

        $result = new Result();

        $repository = $this->orm->getRepository(RssCache::class);
        if ($repository->findOne(['hash' => $value->getHash(), 'destination' => $this->destination]) !== null) {
            $result->addError('Record already exists');
        }

        return $result;
    }
}
