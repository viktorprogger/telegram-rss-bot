<?php

declare(strict_types=1);

namespace rssBot\models\exceptions;

use InvalidArgumentException;
use Throwable;

class UnknownTypeException extends InvalidArgumentException
{
    public function __construct(int $type, $code = 0, Throwable $previous = null)
    {
        $message = sprintf('Unknown source type "%s"', $type);
        parent::__construct($message, $code, $previous);
    }
}
