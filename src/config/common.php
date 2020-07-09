<?php

declare(strict_types=1);

use rssBot\models\source\repository\ParametersRepository;
use rssBot\models\source\repository\SourceRepositoryInterface;
use rssBot\system\Parameters;
use Yiisoft\Composer\Config\Builder;

return [
    Parameters::class => [
        '__class' => Parameters::class,
        '__construct()' => require Builder::path('params'),
    ],
    SourceRepositoryInterface::class => ParametersRepository::class,

];
