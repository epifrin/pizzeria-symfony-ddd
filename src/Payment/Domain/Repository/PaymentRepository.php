<?php

namespace App\Payment\Domain\Repository;

use App\Payment\Domain\Entity\Payment;
use App\Payment\Domain\ValueObject\PaymentId;
use App\Payment\Domain\ViewModel\PaymentInfo;

interface PaymentRepository
{
    public function save(Payment $entity, bool $flush = false): void;

    public function findOneByPaymentId(PaymentId $paymentId): ?Payment;

    public function findOneByOrderId(string $orderId): PaymentInfo;
}
