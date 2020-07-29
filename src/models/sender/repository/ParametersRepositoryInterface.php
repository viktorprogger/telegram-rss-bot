<?php

declare(strict_types=1);

namespace rssBot\models\sender\repository;

use Psr\Container\ContainerInterface;
use rssBot\models\sender\SenderInterface;
use rssBot\models\source\SourceInterface;
use rssBot\system\Parameters;

class ParametersRepositoryInterface implements SenderRepositoryInterface
{
    private ContainerInterface $container;
    private Parameters $parameters;

    public function __construct(ContainerInterface $container, Parameters $parameters)
    {
        $this->container = $container;
        $this->parameters = $parameters;
    }

    /**
     * @inheritDoc
     */
    public function getBySource(SourceInterface $source): iterable
    {
        return $this->getBySourceCode($source->getCode());
    }

    public function getBySourceCode(string $code): iterable
    {
        foreach ($this->parameters->get("senders") as $source => $senders) {
            if ($source === $code) {
                foreach ($senders as $sender) {
                    yield $this->container->get($sender);
                }

                break;
            }
        }
    }

    public function getByCode($sender): SenderInterface
    {
        return $this->container->get($sender);
    }
}
