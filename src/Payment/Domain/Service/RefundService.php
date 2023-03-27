<?php

namespace App\Payment\Domain\Service;

use App\Common\Domain\ValueObject\OrderId;
use App\Payment\Domain\Repository\PaymentRepository;

class RefundService
{
    public function __construct(private readonly PaymentRepository $paymentRepository)
    {
    }

    public function refund(OrderId $orderId): void
    {
        $payment = $this->paymentRepository->findOneByOrderId($orderId);
        if (is_null($payment)) {
            throw new \DomainException('Payment with order id ' . $orderId . ' not found');
        }
        if ($payment->isPaid() === false) {
            throw new \DomainException('Payment with id ' . $payment->getPaymentId() . ' can not be refunded');
        }

        // set refund: Call PSP

        $payment->setRefund();
        $this->paymentRepository->save($payment);
    }
}
