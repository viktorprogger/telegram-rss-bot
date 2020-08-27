<?php

declare(strict_types=1);

namespace rssBot\neww;

use Yiisoft\Validator\Rules;

class Listener implements ListenerInterface
{
    protected bool $synchronous;
    protected ?Rules $validator;
    /**
     * @var mixed
     */
    protected $definition;
    protected array $definitionNormalized = [];

    public function __construct(
        $actionDefinition,
        ?Rules $validator = null,
        bool $synchronous = true
    ) {
        $this->definition = $actionDefinition;
        $this->validator = $validator;
        $this->synchronous = $synchronous;
    }

    public function getActionDefinition()
    {
        return $this->definition;
    }

    public function isSynchronous(): bool
    {
        return $this->synchronous;
    }

    public function suites($payload): bool
    {
        return $this->validator->validate($payload)->isValid();
    }
}
