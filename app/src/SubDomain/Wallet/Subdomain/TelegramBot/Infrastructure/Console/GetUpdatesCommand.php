<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Infrastructure\Console;

use Resender\Domain\Client\TelegramClientInterface;
use Resender\SubDomain\Wallet\Domain\Entity\User\UserCreationData;
use Resender\SubDomain\Wallet\Domain\Entity\User\UserIdFactoryInterface;
use Resender\SubDomain\Wallet\Domain\Entity\User\UserRepositoryInterface;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\TelegramRequest;
use Sentry\Client;
use Sentry\Severity;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Yiisoft\Yii\Console\ExitCode;

class GetUpdatesCommand extends Command
{
    public function __construct(
        private string $token,
        private TelegramClientInterface $client,
//        private Client $sentry,
        private UserIdFactoryInterface $userIdFactory,
        private UserRepositoryInterface $userRepository,
        string $name = null,
    )
    {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->client->send('getUpdates', $this->token) ?? [] as $result) {
            dump($result);

            if (is_array($result)) {
                if (!isset($result[0])) {
/*                    $this->sentry->captureMessage(
                        'Unexpected getUpdates result: ' . json_encode($result),
                        Severity::warning()
                    );*/

                    continue;
                }

                foreach ($result as $update) {
                    $userId = $this->userIdFactory->create((string) $update['message']['from']['id']);
                    if ($this->userRepository->findById($userId) === null) {
                        $this->userRepository->create(new UserCreationData($userId));
                    }



                    $request = new TelegramRequest($userId, $walletId, $categoryId, $data);
                }
            }
        }

        return ExitCode::OK;
    }
}
