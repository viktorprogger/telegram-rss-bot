<?php

declare(strict_types=1);

namespace rssBot\models\source\repository;

use rssBot\models\source\Factory;
use rssBot\models\source\SourceInterface;
use rssBot\system\Parameters;

class ParametersRepository implements SourceRepositoryInterface
{
    private Factory $factory;
    private Parameters $parameters;

    public function __construct(Factory $factory, Parameters $parameters)
    {
        $this->factory = $factory;
        $this->parameters = $parameters;
    }

    public function get(string $code): SourceInterface
    {
        foreach ($this->getDefinitions() as $definition) {
            if ($definition['code'] === $code) {
                return $this->factory->create($definition);
            }
        }
    }

    private function getDefinitions(): iterable
    {
        yield from $this->parameters->get("sources");
    }

    public function getCodes(): iterable
    {
        foreach ($this->getDefinitions() as $definition) {
            yield $definition['code'];
        }
    }
}
