<?php

declare(strict_types=1);

namespace rssBot\neww;

interface ListenerInterface
{
    public function isSynchronous(): bool;

    public function getAction(): ActionInterface;

    public function suites($payload): bool;
}
