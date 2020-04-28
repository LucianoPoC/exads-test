<?php

declare(strict_types=1);

namespace App\Tests\FizzBuzz;

use App\FizzBuzz\FizzBuzz;
use PHPUnit\Framework\TestCase;

final class FizzBuzzTest extends TestCase
{
    public function testExecuteGiving1AsLastValueShouldReturn1(): void
    {
        $fizzBuzz = new FizzBuzz(1, 1);
        $values = $fizzBuzz->execute();
        $this->assertIsArray($values);
        $this->assertNotEmpty($values);
        $this->assertCount(1, $values);
        $this->assertContains(1, $values);
    }

    public function testExecuteGiving2AsLastValueShouldReturn1And2(): void
    {
        $fizzBuzz = new FizzBuzz(1, 2);
        $values = $fizzBuzz->execute();
        $this->assertIsArray($values);
        $this->assertNotEmpty($values);
        $this->assertCount(2, $values);
        $this->assertContains(1, $values);
        $this->assertContains(2, $values);
    }

    public function testExecuteGiving3AsLastValueShouldReturn1And2AndFizz(): void
    {
        $fizzBuzz = new FizzBuzz(1, 3);
        $values = $fizzBuzz->execute();
        $this->assertCount(3, $values);
        $this->assertContains(1, $values);
        $this->assertContains(2, $values);
        $this->assertContains('Fizz', $values);
        $this->assertArrayHasKey(2, $values);
        $this->assertIsString($values[2]);
        $this->assertSame('Fizz', $values[2]);
    }

    public function testExecuteGiving5AsLastValueShouldReturn1And2AndFizzAnd4AndBuzz(): void
    {
        $fizzBuzz = new FizzBuzz(1, 5);
        $values = $fizzBuzz->execute();
        $this->assertCount(5, $values);
        $this->assertContains('Buzz', $values);
        $this->assertArrayHasKey(4, $values);
        $this->assertIsString($values[4]);
        $this->assertSame('Buzz', $values[4]);
    }

    public function testExecuteGiving15AsLastValueShouldReturnFizzBuzzInTheLastPosition(): void
    {
        $fizzBuzz = new FizzBuzz(1, 15);
        $values = $fizzBuzz->execute();
        $this->assertCount(15, $values);
        $this->assertContains('FizzBuzz', $values);
        $this->assertArrayHasKey(14, $values);
        $this->assertIsString(end($values));
        $this->assertSame('FizzBuzz', end($values));
    }

    public function dataProvider(): array
    {
        return [
            [1, 15],
            [1, 42],
            [1, 50],
            [1, 100]
        ];
    }

    /**
     * @dataProvider dataProvider
     *
     * @param int $start
     * @param int $finish
     */
    public function testExecuteGivingValuesShouldReturnKeywords(int $start, int $finish): void
    {
        $fizzBuzz = new FizzBuzz($start, $finish);
        $values = $fizzBuzz->execute();
        $this->assertCount($finish, $values);
        $this->assertContains('Fizz', $values);
        $this->assertContains('Buzz', $values);
        $this->assertContains('FizzBuzz', $values);
    }
}
