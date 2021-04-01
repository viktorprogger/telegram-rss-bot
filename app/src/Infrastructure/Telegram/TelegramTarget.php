<?php

declare(strict_types=1);

namespace Resender\Infrastructure\Telegram;

use GuzzleHttp\Client;
use Resender\Domain\Source\Github\GithubNotification;
use Resender\Domain\Source\Rss\RssItem;
use Resender\Domain\Target\TargetInterface;
use RuntimeException;

final class TelegramTarget implements TargetInterface
{
    private const URI = 'https://api.telegram.org/';

    public function __construct(
        private string $token,
        private string $chatId,
        private Client $client
    ) {
    }

    /**
     * @see https://core.telegram.org/bots/api#sendmessage
     * @see https://core.telegram.org/bots/faq#my-bot-is-hitting-limits-how-do-i-avoid-this
     */
    private function send(TelegramMessage $message): void
    {
        $json = [
            'text' => $message->getText(),
            'chat_id' => $this->chatId,
        ];

        if ($message->getFormat()->isMarkdown()) {
            $json['parse_mode'] = 'Markdown';
        } elseif ($message->getFormat()->isHtml()) {
            $json['parse_mode'] = 'HTML';
        }

        $options = ['json' => $json];
        $this->client->post(self::URI . 'bot' . $this->token . '/sendMessage', $options);
    }

    public function sendRssItem(RssItem $item): void
    {
        $body = html_entity_decode($item->getDescription());
        $body = strip_tags($body);
        $body = trim($body);

        $result = '*' . $item->getTitle() . "*\n";
        $result .= $body . "\n\n";

        if ($item->getLink() !== null) {
            $result .= "[Читать дальше ->](" . $item->getLink() . ")";
        }
    }

    public function sendGithubNotification(GithubNotification $notification): void
    {
        throw new RuntimeException('Not implemented');
    }
}
