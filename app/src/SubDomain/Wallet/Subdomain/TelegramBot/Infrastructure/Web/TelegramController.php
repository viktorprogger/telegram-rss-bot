<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Infrastructure\Web;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Resender\SubDomain\Wallet\Domain\Entity\User\UserIdFactoryInterface;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\TelegramRequest;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Infrastructure\Queue\WebhookMessage;
use Yiisoft\Yii\Queue\QueueFactoryInterface;

final class TelegramController
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
        private QueueFactoryInterface $queueFactory,
        private UserIdFactoryInterface $userIdFactory,
    ) {
    }

    public function webhook(ServerRequestInterface $request): ResponseInterface
    {
        // TODO Вынести все TODO в Space в задачи

        // TODO TelegramRequestFactory, собирающий реквест из ServerRequestInterface
        // TODO StateService - получает и персистит стейт для юзера
        // TODO Обработчик для сообщения в очереди, который будет вызывать роутинг
        // TODO Надо после формирования ответного сообщения как-то добавлять его снова в очередь. Мидлварью, думаю.
        // TODO Нужна новая реализация фабрики каналов очереди, которая будет играться с обменниками
        // TODO Прикрутить php-accounting: добавить в зависимости и понаделать ему orm-моделек
        // TODO Реализовать все действия всех стейтов

        $telegramRequest = new TelegramRequest(
            $userId,
            $walletId,
            $categoryId,
            $data
        );

        $message = new WebhookMessage($state, $telegramRequest);
        $this->queueFactory->get(WebhookMessage::NAME)->push($message);

        return $this->responseFactory->createResponse();
    }
}
