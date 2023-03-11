<?php

namespace App\Payment\Domain\ValueObject;

enum PaymentStatus: int
{
    case NEW = 0;
    case PAID = 1;
    case CANCELLED = 2;
}
