<?php

declare(strict_types=1);

namespace rssBot\models\source;

use rssBot\models\source\exceptions\UnknownTypeException;
use rssBot\models\source\rss\Source;
use Yiisoft\Factory\Factory as GlobalFactory;

class Factory
{
    private GlobalFactory $factory;

    public function __construct(GlobalFactory $factory)
    {
        $this->factory = $factory;
    }

    public function create($config): SourceInterface
    {
        /** @var SourceType $type */
        $type = $config['type'];
        switch ($type->current()) {
            case SourceType::RSS:
                $factoryConfig = [
                    '__construct()' => $config,
                    '__class' => Source::class,
                ];

                return $this->factory->create($factoryConfig);
                break;
            default:
                throw new UnknownTypeException($type->current());
                break;
        }
    }
}
