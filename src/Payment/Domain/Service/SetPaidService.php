<?php

namespace App\Payment\Domain\Service;

use App\Common\Domain\Event\OrderPaidEvent;
use App\Payment\Domain\Repository\PaymentRepository;
use App\Payment\Domain\ValueObject\PaymentId;
use Psr\EventDispatcher\EventDispatcherInterface;

final class SetPaidService
{
    public function __construct(
        private readonly PaymentRepository $paymentRepository,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function setPaid(PaymentId $paymentId): bool
    {
        $payment = $this->paymentRepository->findOneByPaymentId($paymentId);
        if (is_null($payment)) {
            throw new \DomainException('Payment ' . $paymentId . ' not found');
        }
        if ($payment->isNew() === false) {
            throw new \DomainException('Payment ' . $paymentId . ' status is not NEW');
        }

        // set paid: Call PSP

        $payment->setPaid();
        $this->paymentRepository->save($payment);

        $this->eventDispatcher->dispatch(
            new OrderPaidEvent($payment->getOrderId())
        );

        return true;
    }
}
