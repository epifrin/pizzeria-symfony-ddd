<?php

namespace App\Delivery\Infrastructure\Helper;

class ArrayRand
{
    /**
     * @param array<int, mixed> $array
     */
    public function rand(array $array): int
    {
        return array_rand($array);
    }
}
