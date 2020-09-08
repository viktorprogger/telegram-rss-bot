<?php

declare(strict_types=1);

namespace rssBot\neww;

use RuntimeException;
use Yiisoft\Factory\Factory;
use Yiisoft\Yii\Queue\MessageInterface;
use Yiisoft\Yii\Queue\Payload\PayloadInterface;

class ActionFactory implements ActionFactoryInterface
{
    /**
     * @var Factory
     */
    private Factory $factory;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function createAction($definition, $payload)
    {
        // TODO: Implement createAction() method.
    }

    public function createFromMessage(MessageInterface $message): ActionInterface
    {
        $definition = $message->getPayloadData()['action'] ?? null;
        if (!$this->factory->has($definition)) {
            throw new RuntimeException('Deferred listener message must provide an action id registered in the factory.');
        }

        return $this->factory->create($definition);
    }

    public function createPayload(ActionInterface $action, $result): PayloadInterface
    {
        $definition = [
            '__class' => ActionPayload::class,
            '__construct()' => [$action, $result],
        ];

        return $this->factory->create($definition);
    }
}
