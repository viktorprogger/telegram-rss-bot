<?php

declare(strict_types=1);

namespace rssBot\neww;

use rssBot\action\ActionInterface;
use Yiisoft\Yii\Queue\MessageInterface;
use Yiisoft\Yii\Queue\Payload\PayloadInterface;

interface ActionFactoryInterface
{
    public function createAction(MessageInterface $message): ActionInterface;
    public function createPayload(ActionInterface $action): PayloadInterface;
}
