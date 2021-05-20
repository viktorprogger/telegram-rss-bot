<?php

declare(strict_types=1);

use Resender\Infrastructure\Web\ApplicationRunner;

file_put_contents(dirname(__DIR__) . '/runtime/logs/test.php', date('[Y-m-d H:i:s]') . "  test\n", FILE_APPEND);

require_once dirname(__DIR__) . '/vendor/autoload.php';

$runner = new ApplicationRunner();
$runner->debug();
$runner->run();
