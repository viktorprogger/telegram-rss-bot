<?php

declare(strict_types=1);

namespace rssBot\queue;

use Yiisoft\Yii\Queue\Driver\AMQP\Settings\QueueSettingsInterface;

interface FetchQueueSettings extends QueueSettingsInterface
{
}
