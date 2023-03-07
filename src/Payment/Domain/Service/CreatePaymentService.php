<?php

namespace App\Payment\Domain\Service;

use App\Common\Domain\ValueObject\Money;
use App\Common\Domain\ValueObject\OrderId;
use App\Payment\Domain\Entity\Payment;
use App\Payment\Domain\Repository\PaymentRepository;
use App\Payment\Domain\ValueObject\PaymentId;
use App\Payment\Domain\ValueObject\PaymentStatus;
use Symfony\Component\Uid\Factory\UuidFactory;

class CreatePaymentService
{
    public function __construct(
        private readonly PaymentRepository $paymentRepository,
        private readonly UuidFactory $uuidFactory,
    ) {
    }

    public function create(OrderId $orderId, Money $amount): void
    {
        $payment = new Payment();
        $payment->setPaymentId(new PaymentId($this->uuidFactory->create()));
        $payment->setOrderId($orderId);
        $payment->setAmount($amount);
        $payment->setStatus(PaymentStatus::NEW);

        $this->paymentRepository->save($payment, true);
    }
}
