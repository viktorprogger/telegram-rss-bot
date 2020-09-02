<?php

declare(strict_types=1);

namespace rssBot\neww;

use rssBot\neww\ActionInterface;
use Yiisoft\Yii\Queue\MessageInterface;
use Yiisoft\Yii\Queue\Payload\PayloadInterface;

interface ActionFactoryInterface
{
    public function createAction($definition, $payload);
    public function createFromMessage(MessageInterface $message): ActionInterface;
    public function createPayload(ActionInterface $action, $result): PayloadInterface;
}
