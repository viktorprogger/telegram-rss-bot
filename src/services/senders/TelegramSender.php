<?php
declare(strict_types=1);

namespace rssBot\services\senders;

use GuzzleHttp\Client;
use rssBot\dto\FeedItemInterface;
use rssBot\services\formatters\FormatterInterface;
use Yii;

class TelegramSender implements SenderInterface
{
    private const URI = 'https://api.telegram.org/';

    private string $token;

    /**
     * @var Client
     */
    private Client $client;

    /**
     * @var FormatterInterface
     */
    private FormatterInterface $formatter;

    public function __construct(Client $client, FormatterInterface $formatter)
    {
        $this->client = $client;
        $this->formatter = $formatter;
        $this->token = Yii::$app->params['bot_token'];
    }

    public function send(FeedItemInterface $item, string $chatId)
    {
        $message = $this->formatter->formatMessage($item);
        $this->client->post(self::URI . $this->token . '/sendMessage', ['json' => json_encode($message, JSON_THROW_ON_ERROR)]);
    }
}
