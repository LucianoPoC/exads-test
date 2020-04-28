<?php

declare(strict_types=1);

namespace App\FizzBuzz;

final class FizzBuzz
{
    private int $first;
    private int $last;

    private const FIZZ = 'Fizz';
    private const BUZZ = 'Buzz';

    public function __construct(int $first = 1, int $last = 100)
    {
        $this->first = $first;
        $this->last = $last;
    }

    public function execute(): array
    {
        $values = [];
        foreach (range($this->first, $this->last) as $integer) {
            if ($this->isMultipleOfThree($integer) && $this->isMultipleOfFive($integer)) {
                $values[] = self::FIZZ . self::BUZZ;
                continue;
            }

            if ($this->isMultipleOfThree($integer)) {
                $values[] = self::FIZZ;
                continue;
            }

            if ($this->isMultipleOfFive($integer)) {
                $values[] = self::BUZZ;
                continue;
            }

            $values[] = $integer;
        }

        return $values;
    }

    private function isMultipleOfThree(int $integer): bool
    {
        return 0 === $integer % 3;
    }

    private function isMultipleOfFive(int $integer): bool
    {
        return 0 === $integer % 5;
    }
}
