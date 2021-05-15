<?php

declare(strict_types=1);

namespace Resender\SubDomain\Rss\Infrastructure\Web;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Spiral\RoadRunner\Http\PSR7WorkerInterface;
use Throwable;
use Yiisoft\Config\Config;
use Yiisoft\Di\Container;
use Yiisoft\ErrorHandler\ErrorHandler;
use Yiisoft\ErrorHandler\Middleware\ErrorCatcher;
use Yiisoft\ErrorHandler\Renderer\HtmlRenderer;
use Yiisoft\ErrorHandler\Renderer\PlainTextRenderer;
use Yiisoft\Http\Method;
use Yiisoft\Log\Logger;
use Yiisoft\Log\Target\File\FileTarget;
use Yiisoft\Yii\Event\ListenerConfigurationChecker;
use Yiisoft\Yii\Web\Application;
use Yiisoft\Yii\Web\SapiEmitter;
use Yiisoft\Yii\Web\ServerRequestFactory;

use function dirname;
use function microtime;


final class ApplicationRunner
{
    private bool $debug = false;

    public function debug(bool $enable = true): void
    {
        $this->debug = $enable;
    }

    public function run(): void
    {
        $startTime = microtime(true);
        // Register temporary error handler to catch error while container is building.
        $tmpLogger = new Logger([new FileTarget(dirname(__DIR__, 3) . '/runtime/logs/app.log')]);
        $errorHandler = new ErrorHandler($tmpLogger, new PlainTextRenderer());
        $this->registerErrorHandler($errorHandler);

        $config = new Config(
            dirname(__DIR__, 3),
            '/config/packages', // Configs path.
        );

        $container = new Container(
            $config->get('web'),
            $config->get('providers-web')
        );

        // Register error handler with real container-configured dependencies.
        $this->registerErrorHandler($container->get(ErrorHandler::class), $errorHandler);

        $container = $container->get(ContainerInterface::class);

        if ($this->debug) {
            $container->get(ListenerConfigurationChecker::class)->check($config->get('events-web'));
        }

        /** @var Application $application */
        $application = $container->get(Application::class);
        $worker = $container->get(PSR7WorkerInterface::class);

        while ($request = $worker->waitRequest()) {
            $request = $request->withAttribute('applicationStartTime', $startTime);

            try {
                $application->start();
                $response = $application->handle($request);

                $worker->respond($response);
            } catch (Throwable $throwable) {
                $handler = $this->createThrowableHandler($throwable);
                $response = $container->get(ErrorCatcher::class)->process($request, $handler);

                $worker->respond($response);
            } finally {
                $application->afterEmit($response ?? null);
                $application->shutdown();
            }
        }
    }

    private function createThrowableHandler(Throwable $throwable): RequestHandlerInterface
    {
        return new class($throwable) implements RequestHandlerInterface {
            private Throwable $throwable;

            public function __construct(Throwable $throwable)
            {
                $this->throwable = $throwable;
            }

            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                throw $this->throwable;
            }
        };
    }

    private function registerErrorHandler(ErrorHandler $registered, ErrorHandler $unregistered = null): void
    {
        if ($unregistered !== null) {
            $unregistered->unregister();
        }

        if ($this->debug) {
            $registered->debug();
        }

        $registered->register();
    }
}
