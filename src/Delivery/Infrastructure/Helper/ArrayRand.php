<?php

namespace App\Delivery\Infrastructure\Helper;

class ArrayRand
{
    public function rand(array $array): int
    {
        return array_rand($array);
    }
}
