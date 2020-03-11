<?php

declare(strict_types=1);

namespace rssBot\models\source;

use rssBot\system\Parameters;

class FileRepository implements SourceRepositoryInterface
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

    public function get(array $codes, int $timestamp): iterable
    {
        // TODO заюзать timestamp (как-то сохранять дату последнего фетча)

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
