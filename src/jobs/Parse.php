<?php

declare(strict_types=1);

namespace rssBot\jobs;

use Cycle\ORM\ORM;
use Cycle\ORM\Transaction;
use rssBot\sources\SourceInterface;
use yii\queue\JobInterface;
use yii\queue\Queue;
use Yiisoft\Factory\Factory;

class Parse implements JobInterface
{
    /**
     * @var SourceInterface
     */
    private SourceInterface $source;
    /**
     * @var Queue
     */
    private Queue $queue;
    /**
     * @var ORM
     */
    private ORM $orm;
    /**
     * @var Factory
     */
    private Factory $factory;

    public function __construct(SourceInterface $source, Queue $queue, ORM $orm, Factory $factory)
    {
        $this->source = $source;
        $this->queue = $queue;
        $this->orm = $orm;
        $this->factory = $factory;
    }

    /**
     * @inheritDoc
     */
    public function execute($queue)
    {
        foreach ($this->source->getItems() as $item) {
            $repository = $this->orm->getRepository(get_class($item));
            if (!$repository->findOne(['hash' => $item->getHash()])) {
                (new Transaction($this->orm))->persist($item)->run();

                foreach ($this->source->getReceivers() as $receiver) {
                    if ($receiver->suites($item)) {
                        $job = $this->factory->create(Send::class, [$item, $receiver]);
                        $this->queue->push($job);
                    }
                }
            }
        }
    }
}
