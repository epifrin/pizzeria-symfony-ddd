<?php

namespace App\Delivery\Domain\ValueObject;

enum DeliveryStatus: int
{
    case NEW = 0;
    case IN_PROGRESS = 1;
    case DELIVERED = 2;
    case CANCELED = 10;
}
