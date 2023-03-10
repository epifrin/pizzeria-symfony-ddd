<?php

namespace App\Payment\Domain\Query;

use App\Payment\Domain\Repository\PaymentRepository;
use App\Payment\Domain\ViewModel\PaymentInfo;

class GetPaymentInfoQuery
{
    public function __construct(private readonly PaymentRepository $paymentRepository)
    {
    }

    public function getPaymentByOrderId(string $orderId): PaymentInfo
    {
        return $this->paymentRepository->findOneByOrderId($orderId);
    }
}
