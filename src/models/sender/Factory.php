<?php

declare(strict_types=1);

namespace rssBot\models\sender;

use rssBot\models\exceptions\UnknownTypeException;
use rssBot\models\sender\telegram\Sender as TelegramSender;
use Yiisoft\Factory\Factory as GlobalFactory;

class Factory
{
    private GlobalFactory $factory;

    public function __construct(GlobalFactory $factory)
    {
        $this->factory = $factory;
    }

    public function create($config): SenderInterface
    {
        /** @var SenderType $type */
        $type = $config['type'];
        switch ($type->current()) {
            case SenderType::TELEGRAM:
                $factoryConfig = [
                    '__construct()' => $config,
                    '__class' => TelegramSender::class,
                ];

                return $this->factory->create($factoryConfig);
                break;
            default:
                throw new UnknownTypeException($type->current());
                break;
        }
    }
}
