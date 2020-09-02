<?php

declare(strict_types=1);

namespace rssBot\neww;

use Yiisoft\Yii\Queue\MessageInterface;

class MessageHandler
{
    /**
     * @var ActionFactoryInterface
     */
    private ActionFactoryInterface $factory;
    /**
     * @var ActionDispatcher
     */
    private ActionDispatcher $dispatcher;

    public function __construct(ActionFactoryInterface $factory, ActionDispatcher $dispatcher)
    {
        $this->factory = $factory;
        $this->dispatcher = $dispatcher;
    }

    public function handle(MessageInterface $message): void
    {
        $action = $this->factory->createFromMessage($message);
        $result = $action->run($message->getPayloadData()['data'] ?? null);
        $this->dispatcher->dispatch($action, $result);
    }
}
