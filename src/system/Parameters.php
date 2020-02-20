<?php

declare(strict_types=1);

namespace rssBot\system;

use Yiisoft\Arrays\ArrayHelper;

class Parameters
{
    private array $parameters;

    public function __construct(array $data)
    {
        $this->parameters = $data;
    }

    public function get(string $key, $default = null)
    {
        return ArrayHelper::getValue($this->parameters, $key, $default);
    }
}
