<?php

declare(strict_types=1);

namespace rssBot\models\source\rss;

use DateTime;
use rssBot\models\source\ItemInterface as BaseItemInterface;

interface ItemInterface extends BaseItemInterface
{
    public function getTitle(): string;

    public function getDescription(): string;

    public function getLastModified(): ?DateTime;

    public function getLink(): ?string;
}
