<?php

declare(strict_types=1);

namespace rssBot\models\source\repository;

use rssBot\models\source\Factory;
use rssBot\models\source\SourceInterface;

class ParametersRepository implements SourceRepositoryInterface
{
    private Factory $factory;
    private array $sources;

    public function __construct(array $sources, Factory $factory)
    {
        $this->factory = $factory;
        $this->sources = $sources;
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
        yield from $this->sources;
    }

    public function getCodes(): iterable
    {
        foreach ($this->getDefinitions() as $definition) {
            yield $definition['code'];
        }
    }
}
