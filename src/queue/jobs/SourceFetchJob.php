<?php

declare(strict_types=1);

namespace rssBot\queue\jobs;

use rssBot\models\source\SourceInterface;
use rssBot\queue\handlers\SourceFetcher;
use Yiisoft\Yii\Queue\Job\JobInterface;

final class SourceFetchJob implements JobInterface
{
    private SourceInterface $source;
    private SourceFetcher $fetcher;

    public function __construct(SourceInterface $source, SourceFetcher $fetcher)
    {
        $this->source = $source;
        $this->fetcher = $fetcher;
    }

    public function execute(): void
    {
        $this->fetcher->fetch($this->source);
    }
}
