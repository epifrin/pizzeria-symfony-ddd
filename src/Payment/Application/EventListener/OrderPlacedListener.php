<?php

namespace App\Payment\Application\EventListener;

use App\Common\Domain\Event\OrderCreatedEvent;
use App\Payment\Domain\Service\CreatePaymentService;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
class OrderPlacedListener
{
    public function __construct(
        private readonly CreatePaymentService $createPayment
    ) {
    }

    public function __invoke(OrderCreatedEvent $event): void
    {
        $this->createPayment->create($event->getOrderId(), $event->getTotalAmount());
    }
}
