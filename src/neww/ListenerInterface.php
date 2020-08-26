<?php

declare(strict_types=1);

namespace rssBot\neww;

use rssBot\action\ActionInterface;

interface ListenerInterface
{
    public function isSynchronous(): bool;

    public function getAction($data): ActionInterface;
}
