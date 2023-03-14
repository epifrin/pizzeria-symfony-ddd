<?php

namespace App\Order\Domain\ValueObject;

enum OrderStatus: int
{
    case NEW = 0;
    case PREPARED = 1;
    case DELIVERED = 2;
    case CANCELLED = 10;
}
