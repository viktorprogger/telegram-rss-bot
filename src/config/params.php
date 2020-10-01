<?php

declare(strict_types=1);

use Psr\Log\LoggerInterface;
use rssBot\commands\Parse;
use rssBot\models\source\SourceType;
use Spiral\Database\Driver\Postgres\PostgresDriver;
use Yiisoft\Yii\Cycle\Schema\Provider\FromConveyorSchemaProvider;
use Yiisoft\Yii\Cycle\Schema\Provider\FromFileSchemaProvider;
use Yiisoft\Yii\Cycle\Schema\Provider\SimpleCacheSchemaProvider;

return [
    'yiisoft/yii-console' => [
        'commands' => [
            'parse' => Parse::class,
        ],
    ],
    'yiisoft/aliases' => [
        'root' => dirname(__DIR__),
        'src' => '@root/src',
    ],

    // Общий конфиг Cycle
    'yiisoft/yii-cycle' => [
        // Конфиг Cycle DBAL
        'dbal' => [
            /**
             * Логгер SQL запросов
             * Вы можете использовать класс {@see \Yiisoft\Yii\Cycle\Logger\StdoutQueryLogger}, чтобы выводить SQL лог
             * в stdout, или любой другой PSR-совместимый логгер
             */
            'query-logger' => LoggerInterface::class,
            // БД по умолчанию (из списка 'databases')
            'default' => 'default',
            'aliases' => [],
            'databases' => [
                'default' => ['connection' => 'pgsql'],
            ],
            'connections' => [
                // Пример настроек подключения к SQLite:
                'pgsql' => [
                    'driver' => PostgresDriver::class,
                    // Синтаксис подключения описан в https://www.php.net/manual/pdo.construct.php, смотрите DSN
                    'connection' => 'pgsql:host=' . getenv('DB_HOST')
                        . ';port=' . getenv('DB_PORT')
                        . ';dbname=' . getenv('DB_NAME'),
                    'username' => getenv('DB_LOGIN'),
                    'password' => getenv('DB_PASSWORD'),
                ],
            ],
        ],

        // Конфиг миграций
        'migrations' => [
            'directory' => '@root/Migration',
            'namespace' => 'rssBot\\Migration',
            'table' => 'migration',
            'safe' => false,
        ],

        /**
         * Конфиг для фабрики ORM {@see \Yiisoft\Yii\Cycle\Factory\OrmFactory}
         * Указывается определение класса {@see \Cycle\ORM\PromiseFactoryInterface} или null.
         * Документация: @link https://github.com/cycle/docs/blob/master/advanced/promise.md
         */
        'orm-promise-factory' => null,

        /**
         * Список поставщиков схемы БД для {@see \Yiisoft\Yii\Cycle\Schema\SchemaManager}
         * Поставщики схемы реализуют класс {@see SchemaProviderInterface}.
         * Конфигурируется перечислением имён классов поставщиков. Вы здесь можете конфигурировать также и поставщиков,
         * указывая имя класса поставщика в качестве ключа элемента, а конфиг в виде массива элемента:
         */
        'schema-providers' => [
            SimpleCacheSchemaProvider::class => [
                'key' => 'my-custom-cache-key',
            ],
            FromFileSchemaProvider::class => [
                'file' => '@runtime/cycle-schema.php',
            ],
            FromConveyorSchemaProvider::class,
        ],

        /**
         * Настройка для класса {@see \Yiisoft\Yii\Cycle\Schema\Conveyor\AnnotatedSchemaConveyor}
         * Здесь указывается список папок с сущностями.
         * В путях поддерживаются псевдонимы {@see \Yiisoft\Aliases\Aliases}.
         */
        'annotated-entity-paths' => [
            '@src/Entity',
        ],
    ],


    'sources' => [
        'storm' => [
            'type' => SourceType::rss(),
            'title' => 'JetBrains PhpStorm',
            'code' => 'storm',
            'url' => 'https://blog.jetbrains.com/phpstorm/feed/',
        ],
    ],
];
