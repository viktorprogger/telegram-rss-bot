<?php

declare(strict_types=1);

namespace Resender\Infrastructure;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;
use Yiisoft\Yii\Console\Application;

use function Sentry\captureException;

final class ConsoleApplication extends Application
{
    public function __construct(private SentryInitiator $sentry, string $name = 'Resender bot application', string $version = self::VERSION)
    {
        parent::__construct($name, $version);
    }

    public function doRun(InputInterface $input, OutputInterface $output): int
    {
        $this->sentry->register();

        try {
            return parent::doRun($input, $output);
        } catch (Throwable $exception) {
            captureException($exception);

            throw $exception;
        }
    }
}
