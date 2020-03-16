<?php

declare(strict_types=1);

namespace rssBot\models\source\repository;

use rssBot\models\source\Factory;
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

    public function get(array $codes, int $timestamp): iterable
    {
        // TODO заюзать timestamp (как-то сохранять дату последнего фетча)

        foreach ($this->getDefinitions($codes) as $definition) {
            yield $this->factory->create($definition);
        }
    }

    private function getDefinitions(array $codes): iterable
    {
        foreach ($this->parameters->get("sources") as $definition) {
            if ($codes === [] || in_array($definition['code'], $codes, true)) {
                yield $definition;
            }
        }
    }
}
