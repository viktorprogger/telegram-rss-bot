<?php

declare(strict_types=1);

namespace rssBot\models\sender\telegram;

use GuzzleHttp\Client;
use InvalidArgumentException;
use rssBot\models\sender\AbstractSender;
use rssBot\models\sender\converter\ConverterInterface;
use rssBot\models\sender\messages\AbstractMessage;
use rssBot\models\sender\messages\TextMessage;
use rssBot\models\source\rss\ItemInterface as RssItemInterface;

class Sender extends AbstractSender
{
    protected const URI = 'https://api.telegram.org/';

    private string $token;
    private string $chatId;
    private Client $client;

    public function __construct(string $token, string $chatId, Client $client, ConverterInterface $converter)
    {
        $this->token = $token;
        $this->chatId = $chatId;
        $this->client = $client;
        $this->converter = $converter;
    }

    /**
     * @param AbstractMessage|TextMessage $message
     */
    public function send(AbstractMessage $message): void
    {
        if (!$message instanceof TextMessage) {
            throw new InvalidArgumentException('Given item must implement ' . RssItemInterface::class);
        }

        $json = [
            'text' => $message->getText(),
            'chat_id' => $this->chatId,
        ];

        if ($message->getType()->isMarkdown()) {
            $json['parse_mode'] = 'Markdown';
        } elseif ($message->getType()->isHtml()) {
            $json['parse_mode'] = 'HTML';
        }

        // TODO Implement other parameters from https://core.telegram.org/bots/api#sendmessage

        $options = ['json' => $json];
        $this->client->post(self::URI . 'bot' . $this->token . '/sendMessage', $options);
    }
}
