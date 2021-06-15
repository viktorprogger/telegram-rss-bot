<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Infrastructure\Console;

use Psr\Container\ContainerInterface;
use Resender\Domain\Client\TelegramClientInterface;
use Resender\SubDomain\Wallet\Domain\Entity\User\UserCreationData;
use Resender\SubDomain\Wallet\Domain\Entity\User\UserIdFactoryInterface;
use Resender\SubDomain\Wallet\Domain\Entity\User\UserRepositoryInterface;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\Action\GetWalletsAction;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\TelegramRequest;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Yiisoft\Yii\Console\ExitCode;

final class GetUpdatesCommand extends Command
{
    public function __construct(
        private string $token,
        private TelegramClientInterface $client,
//        private Client $sentry,
        private UserIdFactoryInterface $userIdFactory,
        private UserRepositoryInterface $userRepository,
        private ContainerInterface $container,
        string $name = null,
    ) {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->client->send('getUpdates', $this->token)['result'] ?? [] as $update) {
            dump($update);
            $userId = $this->userIdFactory->create((string) $update['message']['from']['id']);
            if ($this->userRepository->findById($userId) === null) {
                $this->userRepository->create(new UserCreationData($userId));
            }

            if (trim($update['message']['text']) === '/start') {
                $action = $this->container->get(GetWalletsAction::class);
                dump($action->handle(new TelegramRequest($userId, (string) $update['message']['chat']['id'])));
                $this->client->sendMessage(
                    $this->token,
                    $action->handle(new TelegramRequest($userId, (string) $update['message']['chat']['id']))
                );
            }
        }

        return ExitCode::OK;
    }
}
