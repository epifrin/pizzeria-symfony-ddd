<?php

namespace App\Payment\Domain\ViewModel;

use App\Common\Domain\ValueObject\Money;

/**
 * @immutable
 */
class PaymentInfo
{
    public string $paymentId;
    public string $totalAmount;

    public function __construct(string $paymentId, Money $totalAmount)
    {
        $this->paymentId = $paymentId;
        $this->totalAmount = $totalAmount->getUSD();
    }
}
