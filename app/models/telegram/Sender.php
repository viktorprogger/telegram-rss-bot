<?php

declare(strict_types=1);

namespace rssBot\models\telegram;

use GuzzleHttp\Client;
use rssBot\models\messages\TextMessage;

class Sender
{
    protected const URI = 'https://api.telegram.org/';

    private string $token;
    private string $chatId;
    private Client $client;

    public function __construct(
        string $token,
        string $chatId,
        Client $client
    ) {
        $this->token = $token;
        $this->chatId = $chatId;
        $this->client = $client;
    }

    public function send(TextMessage $message): void
    {
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
        // TODO Implement delay between messages due to official restrictions https://core.telegram.org/bots/faq#my-bot-is-hitting-limits-how-do-i-avoid-this

        $options = ['json' => $json];
        $this->client->post(self::URI . 'bot' . $this->token . '/sendMessage', $options);
    }
}
