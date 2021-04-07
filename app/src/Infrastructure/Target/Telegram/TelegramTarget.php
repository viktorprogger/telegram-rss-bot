<?php

declare(strict_types=1);

namespace Resender\Infrastructure\Target\Telegram;

use Resender\Domain\Target\TargetInterface;
use Resender\Infrastructure\Source\Github\GithubNotification;
use Resender\Infrastructure\Source\Rss\RssEntry;
use RuntimeException;

final class TelegramTarget implements TargetInterface
{
    public function __construct(
        private string $token,
        private string $chatId,
        private TelegramClientInterface $client
    ) {
    }

    /**
     * @see https://core.telegram.org/bots/api#sendmessage
     * @see https://core.telegram.org/bots/faq#my-bot-is-hitting-limits-how-do-i-avoid-this
     */
    private function send(TelegramMessage $message): void
    {
        $format = null;
        if ($message->getFormat()->isMarkdown()) {
            $format = 'MarkdownV2';
        } elseif ($message->getFormat()->isHtml()) {
            $format = 'HTML';
        }

        $this->client->send($this->token, $this->chatId, $message->getText(), $format);
    }

    public function sendRssItem(RssEntry $item): void
    {
        $markdownEscapeRegex = '/([*_\[\]()>~#+=|{}.!-])/';

        $body = html_entity_decode($item->getDescription());
        $body = strip_tags($body);
        $body = trim($body);
        $body = preg_replace($markdownEscapeRegex, '\\\$1', $body);

        $result = '*' . preg_replace($markdownEscapeRegex, '\\\$1', $item->getTitle()) . "*\n";
        $result .= '_' . $item->getSourceTitle() . "_\n\n";
        $result .= $body . "\n\n";

        if ($item->getLink() !== null) {
            $result .= "[Read more →](" . $item->getLink() . ")";
        }

        $message = new TelegramMessage($result, MessageFormat::markdown());
        $this->send($message);
    }

    public function sendGithubNotification(GithubNotification $notification): void
    {
        throw new RuntimeException('Not implemented');
    }
}
