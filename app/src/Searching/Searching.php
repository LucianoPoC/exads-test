<?php

declare(strict_types=1);

namespace App\Searching;

final class Searching
{
    private int $removedValue = -1;

    private int $removedPosition = -1;

    private array $values;

    public function __construct(RandomFactoryInterface $factory)
    {
        $this->values = $factory->get();
    }

    public function handle(): int
    {
        $this->removedValue = array_rand($this->values, 1);
        $this->removedPosition = array_search($this->removedValue, $this->values, true);
        unset($this->values[$this->removedPosition]);

        return $this->findMissingNumber();
    }

    /**
     * Using XOR method we can flip bit to discovery the missing number:
     *
     * Formula: A XOR B = ? => ? XOR A = B
     *
     * Also we can use a less performance alternative = (N * (N + 1)) / 2.
     *
     * Big O notation: The complexity of the XOR to find a missing number in an array of integers values is O(n)
     * @return int missing number
     */
    private function findMissingNumber(): int
    {
        $a = 0;
        $b = 1;
        $i = 2;
        foreach ($this->values as $value) {
            $a ^= $value; //XOR all the elements in the array
            $b ^= $i++;  //XOR all numbers from 1 to size for the array
        }

        return $a ^ $b; //Finally resolving the XOR between them will result in the missing value
    }

    public function removedPosition(): ?int
    {
        return $this->removedPosition;
    }

    public function removedValue(): ?int
    {
        return $this->removedValue;
    }

    public function values(): array
    {
        return $this->values;
    }
}
