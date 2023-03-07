<?php

namespace App\Payment\Domain\ValueObject;

enum PaymentStatus: int
{
    case NEW = 0;
}
