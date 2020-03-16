<?php

declare(strict_types=1);

namespace rssBot\queue\handlers;

use rssBot\models\source\SourceInterface;
use rssBot\queue\messages\SourceItemMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class SourceFetcher implements MessageHandlerInterface
{
    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(SourceInterface $source)
    {
        foreach ($source->getItems() as $item) {
            $this->bus->dispatch(new SourceItemMessage($item));
        }
    }
}
