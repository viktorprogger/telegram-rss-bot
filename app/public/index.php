<?php

declare(strict_types=1);

use Resender\Infrastructure\Web\ApplicationRunner;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$runner = new ApplicationRunner();
$runner->debug();
$runner->run();
