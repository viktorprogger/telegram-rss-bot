<?php

declare(strict_types=1);

namespace rssBot\models\sender\telegram;

use GuzzleHttp\Client;
use rssBot\models\sender\AbstractSender;
use rssBot\models\sender\SenderInterface;
use rssBot\models\source\ItemInterface;

class Sender extends AbstractSender
{
    private string $token;
    private string $chatId;
    private Client $client;

    public function __construct(string $token, string $chatId, Client $client)
    {
        $this->token = $token;
        $this->chatId = $chatId;
        $this->client = $client;
    }

    public function send(ItemInterface $item): void
    {

    }
}
