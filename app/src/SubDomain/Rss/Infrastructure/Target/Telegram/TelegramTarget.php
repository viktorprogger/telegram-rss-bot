<?php

declare(strict_types=1);

namespace Resender\SubDomain\Rss\Infrastructure\Target\Telegram;

use Resender\Domain\Client\Telegram\MessageFormat;
use Resender\Domain\Client\Telegram\TelegramMessage;
use Resender\Domain\Client\TelegramClientInterface;
use Resender\SubDomain\Rss\Domain\Source\Entry;
use Resender\SubDomain\Rss\Domain\Target\TargetIdInterface;
use Resender\SubDomain\Rss\Domain\Target\TargetInterface;

final class TelegramTarget implements TargetInterface
{
    public function __construct(
        private TargetIdInterface $id,
        private string $token,
        private string $chatId,
        private TelegramClientInterface $client
    ) {
    }

    public function getId(): TargetIdInterface
    {
        return $this->id;
    }

    /**
     * @see https://core.telegram.org/bots/api#sendmessage
     * @see https://core.telegram.org/bots/faq#my-bot-is-hitting-limits-how-do-i-avoid-this
     */
    private function sendInternal(TelegramMessage $message): void
    {
    }

    public function send(Entry $item): void
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

        $message = new TelegramMessage($result, MessageFormat::markdown(), $this->chatId);
        $this->client->sendMessage($this->token, $message);
    }
}
