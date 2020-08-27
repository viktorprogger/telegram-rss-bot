<?php

declare(strict_types=1);

namespace rssBot\neww;

use rssBot\neww\ActionInterface;

interface ActionDispatcherInterface
{
    public function dispatch(ActionInterface $action, $result): void;
}
