<?php

declare(strict_types=1);

namespace Resender\Test\Unit\Infrastructure\Source;

use PHPUnit\Framework\TestCase;
use Resender\Domain\Source\SourceInterface;
use Resender\Infrastructure\Source\StaticSourceRepository;

class StaticSourceRepositoryTest extends TestCase
{
    public function testGetSources()
    {
        $sources = [
            $this->createMock(SourceInterface::class),
            $this->createMock(SourceInterface::class),
        ];

        $repository = new StaticSourceRepository(...$sources);

        self::assertEquals($sources, $repository->getSources());
    }
}
