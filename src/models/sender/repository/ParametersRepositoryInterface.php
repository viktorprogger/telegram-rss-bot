<?php

declare(strict_types=1);

namespace rssBot\models\sender\repository;

use rssBot\models\sender\Factory;
use rssBot\models\source\SourceInterface;
use rssBot\system\Parameters;

class ParametersRepositoryInterface implements SenderRepositoryInterface
{
    private Factory $factory;
    private Parameters $parameters;

    public function __construct(Factory $factory, Parameters $parameters)
    {
        $this->factory = $factory;
        $this->parameters = $parameters;
    }

    /**
     * @inheritDoc
     */
    public function getBySource(SourceInterface $source): iterable
    {
        foreach ($this->parameters->get("senders") as $senderConfig) {
            foreach ($senderConfig['sources'] as $sourceDefinition) {
                if ($sourceDefinition['code'] === $source->getCode()) {
                    yield $this->factory->create($senderConfig);

                    break;
                }
            }
        }
    }
}
