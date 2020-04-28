<?php

declare(strict_types=1);

namespace App\Tests\Searching;

use App\Searching\RandomFactoryInterface;
use App\Searching\RandomValuesFactory;
use PHPUnit\Framework\TestCase;

final class RandomValuesFactoryTest extends TestCase
{
    private RandomFactoryInterface $factory;

    protected function setUp(): void
    {
        $this->factory = new RandomValuesFactory();
    }

    public function testGetGiving500ShouldReturn500Elements(): void
    {
        $values = $this->factory->get(500);
        $this->assertCount(500, $values);
    }

    public function testGetGiving1000ShouldReturn1000Elements(): void
    {
        $values = $this->factory->get(1000);
        $this->assertCount(1000, $values);
    }
}
