<?php

declare(strict_types=1);

namespace Resender\Domain\Target;

use Resender\Infrastructure\Source\Github\GithubNotification;
use Resender\Infrastructure\Source\Rss\RssEntry;

interface TargetInterface
{
    public function sendRssItem(RssEntry $item): void;

    public function sendGithubNotification(GithubNotification $notification): void;
}
