<?php

namespace App\Order\Domain\ValueObject;

enum OrderStatus: int
{
    case NEW = 0;
    case CANCELLED = 1;
    case PREPARED = 2;
    case DELIVERED = 3;
}
