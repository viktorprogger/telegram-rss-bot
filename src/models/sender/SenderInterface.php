<?php

declare(strict_types=1);

namespace rssBot\models\sender;

use rssBot\models\sender\converter\ConverterInterface;
use rssBot\models\sender\messages\AbstractMessage;
use rssBot\models\sender\messages\MessageInterface;
use Yiisoft\Validator\Rule;

interface SenderInterface
{
    public function send(MessageInterface $message): void;

    /**
     * @param Rule|callable ...$filters
     *
     * @return mixed
     */
    public function addPreFilter(...$filters);

    /**
     * @param Rule|callable ...$filters
     *
     * @return mixed
     */
    public function addPostFilter(...$filters);

    public function suits(MessageInterface $message): bool;

    public function getConverter(): ConverterInterface;

    public function getCode(): string;
}
