<?php

declare(strict_types=1);

namespace rssBot\sources;

use rssBot\system\Parameters;

class Repository
{
    /**
     * @var Factory
     */
    private Factory $factory;
    /**
     * @var Parameters
     */
    private Parameters $parameters;

    public function __construct(Factory $factory, Parameters $parameters)
    {
        $this->factory = $factory;
        $this->parameters = $parameters;
    }

    public function get(array $codes = []): iterable
    {
        if ($codes === []) {
            $codes = array_keys($this->parameters->get('sources'));
        }

        foreach ($this->getDefinitions($codes) as $definition) {
            yield $this->factory->create($definition);
        }
    }

    private function getDefinitions(array $codes): iterable
    {
        foreach ($codes as $code) {
            yield $this->parameters->get("sources.$code");
        }
    }
}
