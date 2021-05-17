<?php

declare(strict_types=1);

use Yiisoft\ErrorHandler\Renderer\PlainTextRenderer;
use Yiisoft\ErrorHandler\ThrowableRendererInterface;

/**
 * @var array $params
 */

return [
    ThrowableRendererInterface::class => PlainTextRenderer::class,
];
