<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Infrastructure\Console;

use Cycle\ORM\ORM;
use Cycle\ORM\Transaction;
use DateTimeImmutable;
use DateTimeZone;
use Psr\Container\ContainerInterface;
use Resender\Domain\Client\TelegramClientInterface;
use Resender\SubDomain\Wallet\Domain\Entity\User\UserCreationData;
use Resender\SubDomain\Wallet\Domain\Entity\User\UserIdFactoryInterface;
use Resender\SubDomain\Wallet\Domain\Entity\User\UserRepositoryInterface;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\Action\GetWalletsAction;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\TelegramRequest;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Infrastructure\Entity\TelegramUpdateEntity;
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
        private ORM $orm,
        string $name = null,
    ) {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var TelegramUpdateEntity|null $lastUpdate */
        $lastUpdate = $this->orm->getRepository(TelegramUpdateEntity::class)
            ->select()
            ->orderBy('id', 'DESC')
            ->fetchOne();

        $data = ['allowed_updates' => ['message', 'callback_query']];
        if ($lastUpdate !== null) {
            $data['offset'] = $lastUpdate->id + 1;
        }
        foreach ($this->client->send('getUpdates', $this->token, $data)['result'] ?? [] as $update) {
            dump($update);
            $message = $update['message'] ?? $update['callback_query'];
            $userId = $this->userIdFactory->create('tg-' . $message['from']['id']);
            if ($this->userRepository->findById($userId) === null) {
                $this->userRepository->create(new UserCreationData($userId));
            }

            $data = trim($message['text'] ?? $message['data']);
            $chatId = (string) ($message['chat']['id'] ?? $message['message']['chat']['id']);

            if (in_array(trim($data), ['/start'], true)) {
                $action = $this->container->get(GetWalletsAction::class);
                dump($action->handle(new TelegramRequest($userId, $chatId)));
                $this->client->sendMessage(
                    $this->token,
                    $action->handle(new TelegramRequest($userId, $chatId))
                );
            }

            if (strpos($data, '/create_wallet ') === 0) {
                $walletName = trim(explode(' ', $data, 2)[1] ?? '');
                if ($walletName === '') {
                    // TODO send error message
                } else {
                    $action = $this->container->get(GetWalletsAction::class);
                    dump($action->handle(new TelegramRequest($userId, $chatId)));
                    $this->client->sendMessage(
                        $this->token,
                        $action->handle(new TelegramRequest($userId, $chatId))
                    );
                }
            }

            $updateEntity = new TelegramUpdateEntity();
            $updateEntity->contents = json_encode($update);
            $updateEntity->created_at = new DateTimeImmutable(timezone: new DateTimeZone('UTC'));
            $updateEntity->id = $update['update_id'];
            (new Transaction($this->orm))->persist($updateEntity)->run();
        }

        return ExitCode::OK;
    }
}
