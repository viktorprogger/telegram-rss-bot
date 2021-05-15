<?php

declare(strict_types=1);

namespace Resender\SubDomain\Rss\Infrastructure;

use function Sentry\init;

final class SentryInitiator
{
    public function __construct(private string $dsn)
    {
    }

    public function register(): void
    {
        init(['dsn' => $this->dsn]);
    }
}
