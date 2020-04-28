<?php

declare(strict_types=1);

namespace App\Tests\Searching;

use App\Searching\RandomFactoryInterface;
use App\Searching\RandomValuesFactory;
use App\Searching\Searching;
use PHPUnit\Framework\TestCase;

final class SearchingTest extends TestCase
{
    private RandomFactoryInterface $factory;

    protected function setUp(): void
    {
        $this->factory = new RandomValuesFactory();
    }

    public function testHandleGiving500ElementsShouldResultTrue(): void
    {
        $searching = new Searching($this->factory);
        $missingValue = $searching->handle();
        $values = $searching->values();
        $this->assertNotContains($missingValue, $values);
        $this->assertSame($searching->removedValue(), $missingValue);
    }
}
