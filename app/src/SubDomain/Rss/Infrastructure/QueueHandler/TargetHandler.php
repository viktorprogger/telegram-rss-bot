<?php

declare(strict_types=1);

namespace Resender\SubDomain\Rss\Infrastructure\QueueHandler;

use Cycle\ORM\ORM;
use Cycle\ORM\Transaction;
use DateTime;
use Resender\SubDomain\Rss\Domain\Source\Entry;
use Resender\SubDomain\Rss\Domain\Target\TargetRepositoryInterface;
use Resender\SubDomain\Rss\Infrastructure\Source\Entity\RssCache;
use Resender\SubDomain\Rss\Infrastructure\Target\StringTargetId;
use RuntimeException;
use Yiisoft\Yii\Queue\Message\MessageInterface;

final class TargetHandler
{
    public const CHANNEL_NAME = 'rss-target';
    public const MESSAGE_NAME = 'rss-target';

    public function __construct(
        private ORM $orm,
        private TargetRepositoryInterface $targetRepository,
    ) {
    }

    public function handle(MessageInterface $message): void
    {
        $rssRepository = $this->orm->getRepository(RssCache::class);

        ['target' => $targetId, 'item' => $itemData, 'sourceId' => $sourceId] = $message->getData();
        if ($itemData['updated'] !== null) {
            $itemData['updated'] = new DateTime($itemData['updated']);
        }

        $entry = new Entry(...$itemData);

        $filter = [
            'source_id' => $sourceId,
            'target_id' => $targetId,
            'hash' => $entry->getHash(),
        ];
        if ($rssRepository->findOne($filter) === null) {
            $target = $this->targetRepository->getById(new StringTargetId($targetId));
            if ($target === null) {
                throw new RuntimeException("No target with id '$targetId'");
            }

            $tr = new Transaction($this->orm);

            $rssItemCache = new RssCache();
            $rssItemCache->source_id = $sourceId;
            $rssItemCache->target_id = $target->getId()->value();
            $rssItemCache->hash = $entry->getHash();

            $target->send($entry);

            $tr->persist($rssItemCache);
            $tr->run();
        }
    }
}
