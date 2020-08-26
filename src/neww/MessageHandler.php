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

    public function handle(MessageInterface $message)
    {
        $action = $this->factory->createAction($message);
        $result = $action->run();
        $this->dispatcher->dispatch($action, $result);
    }
}
