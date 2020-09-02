<?php

declare(strict_types=1);

namespace rssBot\neww;

use Yiisoft\Serializer\SerializerInterface;
use Yiisoft\Yii\Queue\Payload\PayloadInterface;

class ActionPayload implements PayloadInterface
{
    public const NAME = '';
    private ActionInterface $action;
    /**
     * @var mixed
     */
    private $data;
    private SerializerInterface $serializer;

    public function __construct(ActionInterface $action, $data, SerializerInterface $serializer)
    {
        $this->action = $action;
        $this->data = $data;
        $this->serializer = $serializer;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getData(): array
    {
        return [
            'action' => $this->serializer->serialize($this->action),
            'data' => $this->serializer->serialize($this->data),
        ];
    }

    public function getMeta(): array
    {
        return [];
    }
}
