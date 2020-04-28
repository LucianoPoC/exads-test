<?php

declare(strict_types=1);

namespace App\DistributedTraffic;

use Symfony\Component\HttpFoundation\Response;

final class DistributedTrafficController
{
    public function index(): Response
    {
        $weightedValues = [
            'A' => 50, 'B' => 25, 'C' => 25
        ];

        $rand = random_int(1, (int) array_sum($weightedValues));

        foreach ($weightedValues as $key => $value) {
            $rand -= $value;
            if ($rand <= 0) {
                return new Response(sprintf('Design %s', $key));
            }
        }
    }
}
