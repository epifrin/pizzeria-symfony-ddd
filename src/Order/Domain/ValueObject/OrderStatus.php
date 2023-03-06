<?php

namespace App\Order\Domain\ValueObject;

enum OrderStatus: int
{
    case NEW = 0;
}
