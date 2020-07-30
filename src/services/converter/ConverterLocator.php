<?php

declare(strict_types=1);

namespace rssBot\services\converter;


use Psr\Container\ContainerInterface;
use rssBot\models\sender\converter\ConverterInterface;
use rssBot\models\sender\SenderInterface;
use rssBot\models\source\ItemInterface;
use rssBot\system\Parameters;

class ConverterLocator implements ConverterLocatorInterface
{
    private array $definitions;
    private ContainerInterface $container;

    public function __construct(array $definitions, ContainerInterface $container)
    {
        $this->definitions = $definitions;
        $this->container = $container;
    }

    public function getConverter(SenderInterface $sender, ItemInterface $sourceItem): ConverterInterface
    {
        $definition = $this->definitions[$sender->getCode()][$sourceItem->getResourceCode()];

        return $this->container->get($definition);
    }
}
