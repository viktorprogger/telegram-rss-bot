<?php

declare(strict_types=1);

namespace Resender\Domain\Target;

use Resender\Domain\Source\Github\GithubNotification;
use Resender\Domain\Source\Rss\RssItem;

interface TargetInterface
{
    public function sendRssItem(RssItem $item): void;

    public function sendGithubNotification(GithubNotification $notification): void;
}
