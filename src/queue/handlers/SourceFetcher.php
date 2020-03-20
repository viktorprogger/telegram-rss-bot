<?php

declare(strict_types=1);

namespace rssBot\queue\handlers;

use rssBot\models\sender\repository\SenderRepositoryInterface;
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
    /**
     * @var SenderRepositoryInterface
     */
    private SenderRepositoryInterface $repository;

    public function __construct(MessageBusInterface $bus, SenderRepositoryInterface $repository)
    {
        $this->bus = $bus;
        $this->repository = $repository;
    }

    public function __invoke(SourceInterface $source)
    {
        foreach ($source->getItems() as $item) {
            foreach ($this->repository->getBySource($source) as $sender) {
                if ($sender->suits($item)) {
                    $dto = $sender->getConverter()->convert($item);
                    $this->bus->dispatch(new SourceItemMessage($item, $sender));
                }
            }
        }
    }
}
