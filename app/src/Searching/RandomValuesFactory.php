<?php

declare(strict_types=1);

namespace App\Searching;

final class RandomValuesFactory implements RandomFactoryInterface
{
    public function get(int $limit = 500): array
    {
        $values = range(1, $limit);
        shuffle($values);

        return $values;
    }
}
