<?php

declare(strict_types=1);

namespace rssBot\queue\jobs;

use Yiisoft\Yii\Queue\Payload\PayloadInterface;

final class SourceFetchJob implements PayloadInterface
{
    public const NAME = 'resender-bot/source-fetch';
    private string $code;

    public function __construct(string $code)
    {
        $this->code = $code;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getData(): array
    {
        return ['source' => $this->code];
    }

    public function getMeta(): array
    {
        return [];
    }
}
