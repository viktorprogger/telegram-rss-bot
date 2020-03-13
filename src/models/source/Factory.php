<?php

declare(strict_types=1);

namespace rssBot\models\source;

class Factory
{
    private \Yiisoft\Factory\Factory $factory;

    public function __construct(\Yiisoft\Factory\Factory $factory)
    {
        $this->factory = $factory;
    }

    public function create($config): SourceInterface
    {
    }
}
